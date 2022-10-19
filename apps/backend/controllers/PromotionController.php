<?php
namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Repositories\Promotion;
use Indianimmigrationorg\Models\VisaPromotion;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class PromotionController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $keyword = trim($this->request->get("txtSearch"));
        $fromdate = $this->request->get("txtFormDate");
        $todate = $this->request->get("txtToDate");
        $sql = VisaPromotion::query();
        if (!empty($keyword)) {
            if ($validator->validInt($keyword)) {
                $sql->andwhere("promotion_id = :keyword:",["keyword" => $keyword]);
            } else {
                $sql->andwhere("promotion_name like CONCAT('%',:keyword:,'%')",["keyword" => $keyword]);
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if (!empty($fromdate)) {
            $sql->andwhere("promotion_startdate >= :formdate: ",["formdate" => strtotime($fromdate)]);
            $this->dispatcher->setParam("txtFormDate", $fromdate);
        }
        if (!empty($todate)) {
            $sql->andwhere("promotion_startdate <= :todate: ",["todate" => strtotime($todate)]);
            $this->dispatcher->setParam("txtToDate", $todate);
        }
        $sql->orderBy("promotion_id DESC");
        $list_promotion = $sql->execute();
        $paginator = new PaginatorModel(array(
            'data' => $list_promotion,
            'limit' => 20,
            'page' => $current_page,
        ));
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
            $this->view->msg_result = $msg_result;
        }
        if ($this->session->has('msg_del')) {
            $msg_result = $this->session->get('msg_del');
            $this->session->remove('msg_del');
            $this->view->msg_del = $msg_result;
        }
        $this->view->setVars(array(
            'list_promotion' => $paginator->getPaginate(),
        ));
    }


    public function createAction()
    {
        $this->view->pick($this->controllerName.'/model');
        $data = array(
            'promotion_id' => -1,
            'promotion_percent' => '',
            'promotion_startdate' => $this->my->formatTime($this->globalVariable->curTime + 30 * 60),
            'promotion_enddate' => $this->my->formatTime($this->globalVariable->curTime + 60 * 60),
        );
        $code = Promotion::generateRandomString(8);
        if (Promotion::checkCode($code, -1) == false) {
            $data['promotion_code'] = $code;
        }
        if ($this->request->isPost()) {
            $messages = array();
            $data = array(
                'promotion_code' => $this->request->getPost("txtCode", array('string', 'trim')),
                'promotion_percent' => $this->request->getPost("txtPercent", array('string', 'trim')),
                'promotion_startdate' => $this->request->getPost("txtStartDate", array('string', 'trim')),
                'promotion_enddate' => $this->request->getPost("txtEndDate", array('string', 'trim')),
            );
            if (empty($data["promotion_code"])) {
                $messages["code"] = "Code field is required.";
            } else if (Promotion::checkCode($data["promotion_code"], -1)) {
                $messages["code"] = "Code is exists.";
            }
            if (empty($data['promotion_percent'])) {
                $messages["percent"] = "Percent field is required.";
            } else if (!is_numeric($data["promotion_percent"])) {
                $messages["percent"] = "Percent is not valid ";
            }
            if (empty($data["promotion_startdate"])) {
                $messages["start_date"] = "Start Date is required";
            } else {
                if (strtotime($data["promotion_startdate"]) > strtotime($data["promotion_enddate"])) {
                    $messages["start_date"] = "Must be lesser than End Date.";
                }
            }
            if (empty($data["promotion_enddate"])) {
                $messages["end_date"] = "End Date is required";
            }
            if (count($messages) == 0) {
                $data['promotion_startdate'] = $this->my->UTCTime(strtotime($data['promotion_startdate']));
                $data['promotion_enddate'] = $this->my->UTCTime(strtotime($data['promotion_enddate']));
                $msg_result = array();
                $new_Port = new VisaPromotion();
                if ($new_Port->save($data)) {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Promotion Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($new_Port->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }

                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/promotion");
            }
        }
        $messages["status"] = "border-red";
        $this->view->setVars([
            'title' => 'Create Port',
            'formData' => $data,
            'messages' => $messages,
        ]);
    }

    public function editAction()
    {
        $this->view->pick($this->controllerName.'/model');
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            return $this->response->redirect('notfound');
        }
        $promotion_model = Promotion::findFirstById($id);
        if (empty($promotion_model)) {
            return $this->response->redirect('notfound');
        }
        $model_data = $promotion_model->toArray();
        $model_data['promotion_startdate'] = $this->my->formatTime($model_data['promotion_startdate']);
        $model_data['promotion_enddate'] = $this->my->formatTime($model_data['promotion_enddate']);
        $input_data = $model_data;
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'promotion_id' => $id,
                'promotion_code' => $this->request->getPost("txtCode", array('string', 'trim')),
                'promotion_percent' => $this->request->getPost("txtPercent", array('string', 'trim')),
                'promotion_startdate' => $this->request->getPost("txtStartDate", array('string', 'trim')),
                'promotion_enddate' => $this->request->getPost("txtEndDate", array('string', 'trim')),
            );
            $input_data = $data;
            if (empty($data["promotion_code"])) {
                $messages["code"] = "Code field is required.";
            } else if (Promotion::checkCode($data["promotion_code"], $data["promotion_id"])) {
                $messages["code"] = "Code is exists.";
            }
            if (empty($data['promotion_percent'])) {
                $messages["percent"] = "Percent field is required.";
            } else if (!is_numeric($data["promotion_percent"])) {
                $messages["percent"] = "Percent is not valid ";
            }
            if (empty($data["promotion_startdate"])) {
                $messages["start_date"] = "Start Date is required";
            } else {
                if (strtotime($data["promotion_startdate"]) > strtotime($data["promotion_enddate"])) {
                    $messages["start_date"] = "Must be lesser than End Date.";
                }
            }
            if (empty($data["promotion_enddate"])) {
                $messages["end_date"] = "End Date is required";
            }
            if (count($messages) == 0) {
                $msg_result = array();
                $data['promotion_startdate'] = $this->my->UTCTime(strtotime($data['promotion_startdate']));
                $data['promotion_enddate'] = $this->my->UTCTime(strtotime($data['promotion_enddate']));
                if ($promotion_model->update($data)) {
                    $msg_result = array('status' => 'success', 'msg' => 'Edit Promotion Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($promotion_model->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/promotion");
            }
        }
        $messages["status"] = "border-red";
        $this->view->setVars([
            'formData' => $input_data,
            'messages' => $messages,        
        ]);
    }

    public function deleteAction()
    {
        $promotion_checked = $this->request->getPost("item");
        if (!empty($promotion_checked)) {
            $tn_log = array();
            foreach ($promotion_checked as $id) {
                $promotion_item = Promotion::findFirstById($id);
                if ($promotion_item) {
                    $msg_result = array();
                    if ($promotion_item->delete() === false) {
                        $message_delete = 'Can\'t delete the Promotion Name = ' . $promotion_item->getPromotionCode();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $tn_log[$id] = $promotion_item->toArray();
                    }
                }
            }
            if (count($tn_log) > 0) {
                $message_delete = 'Delete ' . count($tn_log) . ' Promotion successfully.';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect("/promotion");
        }
    }
}
