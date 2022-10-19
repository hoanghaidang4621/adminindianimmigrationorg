<?php
namespace Indianimmigrationorg\Models;

use GlobalVariable;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model;

class BaseModel extends Model
{
    public function initialize()
    {
        $eventsManager = new EventsManager();

        // Attach an anonymous function as a listener for 'model' events
        $eventsManager->attach('model', function ($event, $model) {
            /**
             * @var $model Model
             * @var $event Event
             */

            $type = $event->getType();

            $auth = $this->getDI()->getSession()->get('auth');
            $dataActor = [];
            $globalVariable = new GlobalVariable();
            if ($auth) {
                foreach ($auth as $key => $value) {
                    if (in_array($key, ['id', 'email', 'name', 'role', 'tel'])) {
                        $dataActor[$key] = $value;
                    }
                }
            } else if (strripos($_SERVER['REQUEST_URI'], $globalVariable->cronPassword) || strripos($_SERVER['REQUEST_URI'], $globalVariable->cronToken)) {
                $dataActor = [];
                $dataActor['name'] = "CRON";
            }
            $dataActor = json_encode($dataActor);
            if (!in_array($model->getSource(), $globalVariable->listTableNotWriteLog)) {
                $newRecordLogActivity = new VisaLogActivity();
                //GET DATA PRIMARY KEY
                $primaryKeys = $model->getModelsMetaData()->getPrimaryKeyAttributes($model);
                $dataPrimaryKey = [];
                foreach ($primaryKeys as $primaryKey) {
                    $dataPrimaryKey[$primaryKey] = $model->$primaryKey;
                }
                $dataPrimaryKey = json_encode($dataPrimaryKey);

                if ($type == 'afterFetch') {
                    $model->setOldSnapshotData($model->toArray());
                }
                // action create & update
                if ($event->getType() == 'notSaved') {
                    $newRecordLogActivity->setActivityTable($model->getSource());
                    $newRecordLogActivity->setActivityActor($dataActor);
                    $newRecordLogActivity->setActivityPrimaryKeyRecord($dataPrimaryKey);
                    $newRecordLogActivity->setActivityStatus(VisaLogActivity::STATUS_FAILED);
                    $newRecordLogActivity->setActivityDataNew(json_encode($model->toArray()));
                    $newRecordLogActivity->setActivityReasonFailed(implode(", ", $model->getMessages()));
                    if (empty($model->getOldSnapshotData())) {
                        $newRecordLogActivity->setActivityAction('create');
                        $newRecordLogActivity->setActivityDataOld(json_encode([]));
                    } else {
                        $newRecordLogActivity->setActivityAction('update');
                        $newRecordLogActivity->setActivityDataOld(json_encode($model->getOldSnapshotData()));
                    }
                    $newRecordLogActivity->save();
                }

                if ($event->getType() == 'afterSave') {
                    if (!empty(array_diff($model->toArray(), $model->getOldSnapshotData()))
                        || !empty(array_diff($model->getOldSnapshotData(), $model->toArray()))) {
                        $newRecordLogActivity->setActivityTable($model->getSource());
                        $newRecordLogActivity->setActivityActor($dataActor);
                        $newRecordLogActivity->setActivityPrimaryKeyRecord($dataPrimaryKey);
                        $newRecordLogActivity->setActivityStatus(VisaLogActivity::STATUS_SUCCESS);
                        $newRecordLogActivity->setActivityDataNew(json_encode($model->toArray()));

                        if (empty($model->getOldSnapshotData())) {
                            $newRecordLogActivity->setActivityAction('create');
                            $newRecordLogActivity->setActivityDataOld(json_encode([]));
                        } else {
                            $newRecordLogActivity->setActivityAction('update');
                            $newRecordLogActivity->setActivityDataOld(json_encode($model->getOldSnapshotData()));
                        }
                        $result= $newRecordLogActivity->save();
                    }
                }

                //  action Delete
                if ($event->getType() == 'afterDelete') {
                    $newRecordLogActivity->setActivityTable($model->getSource());
                    $newRecordLogActivity->setActivityActor($dataActor);
                    $newRecordLogActivity->setActivityPrimaryKeyRecord($dataPrimaryKey);
                    $newRecordLogActivity->setActivityStatus(VisaLogActivity::STATUS_SUCCESS);
                    $newRecordLogActivity->setActivityDataNew(json_encode([]));

                    $newRecordLogActivity->setActivityAction('delete');
                    $newRecordLogActivity->setActivityDataOld(json_encode($model->getOldSnapshotData()));
                    $newRecordLogActivity->save();
                }
            }
        });

        // Attach the events manager to the event
        $this->setEventsManager($eventsManager);
    }
}