<?php

namespace Indianimmigrationorg\Models;

class VisaCheckStatus extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $check_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $check_full_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $check_passport;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $check_email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $check_number;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=true)
     */
    protected $check_communication_channel_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $check_communication_channel_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $check_communication_channel_number;

    /**
     *
     * @var string
     * @Column(type="string", length=5, nullable=false)
     */
    protected $check_country_code;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $check_request;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $check_insert_time;

    /**
     * Method to set the value of field check_id
     *
     * @param integer $check_id
     * @return $this
     */
    public function setCheckId($check_id)
    {
        $this->check_id = $check_id;

        return $this;
    }

    /**
     * Method to set the value of field check_full_name
     *
     * @param string $check_full_name
     * @return $this
     */
    public function setCheckFullName($check_full_name)
    {
        $this->check_full_name = $check_full_name;

        return $this;
    }

    /**
     * Method to set the value of field check_passport
     *
     * @param string $check_passport
     * @return $this
     */
    public function setCheckPassport($check_passport)
    {
        $this->check_passport = $check_passport;

        return $this;
    }

    /**
     * Method to set the value of field check_email
     *
     * @param string $check_email
     * @return $this
     */
    public function setCheckEmail($check_email)
    {
        $this->check_email = $check_email;

        return $this;
    }

    /**
     * Method to set the value of field check_number
     *
     * @param string $check_number
     * @return $this
     */
    public function setCheckNumber($check_number)
    {
        $this->check_number = $check_number;

        return $this;
    }

    /**
     * Method to set the value of field check_communication_channel_id
     *
     * @param integer $check_communication_channel_id
     * @return $this
     */
    public function setCheckCommunicationChannelId($check_communication_channel_id)
    {
        $this->check_communication_channel_id = $check_communication_channel_id;

        return $this;
    }

    /**
     * Method to set the value of field check_communication_channel_name
     *
     * @param string $check_communication_channel_name
     * @return $this
     */
    public function setCheckCommunicationChannelName($check_communication_channel_name)
    {
        $this->check_communication_channel_name = $check_communication_channel_name;

        return $this;
    }

    /**
     * Method to set the value of field check_communication_channel_number
     *
     * @param string $check_communication_channel_number
     * @return $this
     */
    public function setCheckCommunicationChannelNumber($check_communication_channel_number)
    {
        $this->check_communication_channel_number = $check_communication_channel_number;

        return $this;
    }

    /**
     * Method to set the value of field check_country_code
     *
     * @param string $check_country_code
     * @return $this
     */
    public function setCheckCountryCode($check_country_code)
    {
        $this->check_country_code = $check_country_code;

        return $this;
    }

    /**
     * Method to set the value of field check_request
     *
     * @param string $check_request
     * @return $this
     */
    public function setCheckRequest($check_request)
    {
        $this->check_request = $check_request;

        return $this;
    }

    /**
     * Method to set the value of field check_insert_time
     *
     * @param integer $check_insert_time
     * @return $this
     */
    public function setCheckInsertTime($check_insert_time)
    {
        $this->check_insert_time = $check_insert_time;

        return $this;
    }

    /**
     * Returns the value of field check_id
     *
     * @return integer
     */
    public function getCheckId()
    {
        return $this->check_id;
    }

    /**
     * Returns the value of field check_full_name
     *
     * @return string
     */
    public function getCheckFullName()
    {
        return $this->check_full_name;
    }

    /**
     * Returns the value of field check_passport
     *
     * @return string
     */
    public function getCheckPassport()
    {
        return $this->check_passport;
    }

    /**
     * Returns the value of field check_email
     *
     * @return string
     */
    public function getCheckEmail()
    {
        return $this->check_email;
    }

    /**
     * Returns the value of field check_number
     *
     * @return string
     */
    public function getCheckNumber()
    {
        return $this->check_number;
    }

    /**
     * Returns the value of field check_communication_channel_id
     *
     * @return integer
     */
    public function getCheckCommunicationChannelId()
    {
        return $this->check_communication_channel_id;
    }

    /**
     * Returns the value of field check_communication_channel_name
     *
     * @return string
     */
    public function getCheckCommunicationChannelName()
    {
        return $this->check_communication_channel_name;
    }

    /**
     * Returns the value of field check_communication_channel_number
     *
     * @return string
     */
    public function getCheckCommunicationChannelNumber()
    {
        return $this->check_communication_channel_number;
    }

    /**
     * Returns the value of field check_country_code
     *
     * @return string
     */
    public function getCheckCountryCode()
    {
        return $this->check_country_code;
    }

    /**
     * Returns the value of field check_request
     *
     * @return string
     */
    public function getCheckRequest()
    {
        return $this->check_request;
    }

    /**
     * Returns the value of field check_insert_time
     *
     * @return integer
     */
    public function getCheckInsertTime()
    {
        return $this->check_insert_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasOne(
            ['check_id'],
            'Indianimmigrationorg\Models\VisaActivity',
            ['activity_action_id'],
            [
                'alias' => 'activity',
                'params' => [
                    'conditions' => 'activity_controller = "checkstatus"',
                ]
            ]
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_check_status';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCheckStatus[]|VisaCheckStatus
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCheckStatus
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCheckStatus
     */
    public static function findFirstById($id)
    {
        return self::findFirst([
            'check_id = :ID:',
            'bind'  => [
                'ID' => $id
            ]
        ]);
    }
}
