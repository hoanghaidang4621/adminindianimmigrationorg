<?php

namespace Indianimmigrationorg\Models;

class VisaLogActivity extends \Phalcon\Mvc\Model
{
    const STATUS_SUCCESS = 'SUCCESS';
    const STATUS_FAILED = 'FAILED';

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $activity_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $activity_action;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $activity_table;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $activity_actor;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $activity_primary_key_record;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $activity_data_old;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $activity_data_new;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $activity_status;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $activity_reason_failed;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $activity_insert_time;

    /**
     * Method to set the value of field activity_id
     *
     * @param integer $activity_id
     * @return $this
     */
    public function setActivityId($activity_id)
    {
        $this->activity_id = $activity_id;

        return $this;
    }

    /**
     * Method to set the value of field activity_action
     *
     * @param string $activity_action
     * @return $this
     */
    public function setActivityAction($activity_action)
    {
        $this->activity_action = $activity_action;

        return $this;
    }

    /**
     * Method to set the value of field activity_table
     *
     * @param string $activity_table
     * @return $this
     */
    public function setActivityTable($activity_table)
    {
        $this->activity_table = $activity_table;

        return $this;
    }

    /**
     * Method to set the value of field activity_actor
     *
     * @param string $activity_actor
     * @return $this
     */
    public function setActivityActor($activity_actor)
    {
        $this->activity_actor = $activity_actor;

        return $this;
    }

    /**
     * Method to set the value of field activity_primary_key_record
     *
     * @param string $activity_primary_key_record
     * @return $this
     */
    public function setActivityPrimaryKeyRecord($activity_primary_key_record)
    {
        $this->activity_primary_key_record = $activity_primary_key_record;

        return $this;
    }

    /**
     * Method to set the value of field activity_data_old
     *
     * @param string $activity_data_old
     * @return $this
     */
    public function setActivityDataOld($activity_data_old)
    {
        $this->activity_data_old = $activity_data_old;

        return $this;
    }

    /**
     * Method to set the value of field activity_data_new
     *
     * @param string $activity_data_new
     * @return $this
     */
    public function setActivityDataNew($activity_data_new)
    {
        $this->activity_data_new = $activity_data_new;

        return $this;
    }

    /**
     * Method to set the value of field activity_status
     *
     * @param string $activity_status
     * @return $this
     */
    public function setActivityStatus($activity_status)
    {
        $this->activity_status = $activity_status;

        return $this;
    }

    /**
     * Method to set the value of field activity_reason_failed
     *
     * @param string $activity_reason_failed
     * @return $this
     */
    public function setActivityReasonFailed($activity_reason_failed)
    {
        $this->activity_reason_failed = $activity_reason_failed;

        return $this;
    }

    /**
     * Method to set the value of field activity_insert_time
     *
     * @param integer $activity_insert_time
     * @return $this
     */
    public function setActivityInsertTime($activity_insert_time)
    {
        $this->activity_insert_time = $activity_insert_time;

        return $this;
    }

    /**
     * Returns the value of field activity_id
     *
     * @return integer
     */
    public function getActivityId()
    {
        return $this->activity_id;
    }

    /**
     * Returns the value of field activity_action
     *
     * @return string
     */
    public function getActivityAction()
    {
        return $this->activity_action;
    }

    /**
     * Returns the value of field activity_table
     *
     * @return string
     */
    public function getActivityTable()
    {
        return $this->activity_table;
    }

    /**
     * Returns the value of field activity_actor
     *
     * @return string
     */
    public function getActivityActor()
    {
        return $this->activity_actor;
    }

    /**
     * Returns the value of field activity_primary_key_record
     *
     * @return string
     */
    public function getActivityPrimaryKeyRecord()
    {
        return $this->activity_primary_key_record;
    }

    /**
     * Returns the value of field activity_data_old
     *
     * @return string
     */
    public function getActivityDataOld()
    {
        return $this->activity_data_old;
    }

    /**
     * Returns the value of field activity_data_new
     *
     * @return string
     */
    public function getActivityDataNew()
    {
        return $this->activity_data_new;
    }

    /**
     * Returns the value of field activity_status
     *
     * @return string
     */
    public function getActivityStatus()
    {
        return $this->activity_status;
    }

    /**
     * Returns the value of field activity_reason_failed
     *
     * @return string
     */
    public function getActivityReasonFailed()
    {
        return $this->activity_reason_failed;
    }

    /**
     * Returns the value of field activity_insert_time
     *
     * @return integer
     */
    public function getActivityInsertTime()
    {
        return $this->activity_insert_time;
    }

    /**
     * Initialize method for model.
     */
    /*/*public function initialize()
    {
        $this->setSchema("admin_visa_com");
    }*/

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_log_activity';
    }
    public function beforeValidationOnCreate()
    {
        $this->setActivityInsertTime(time());
    }
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLogActivity[]|VisaLogActivity
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLogActivity
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
