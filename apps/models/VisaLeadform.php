<?php

namespace Indianimmigrationorg\Models;

class VisaLeadform extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $leadform_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $leadform_name;

    /**
     *
     * @var string
     * @Column(type="string", length=5, nullable=false)
     */
    protected $leadform_country_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $leadform_number;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $leadform_email;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $leadform_content;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $leadform_insert_time;

    /**
     * Method to set the value of field leadform_id
     *
     * @param integer $leadform_id
     * @return $this
     */
    public function setLeadformId($leadform_id)
    {
        $this->leadform_id = $leadform_id;

        return $this;
    }

    /**
     * Method to set the value of field leadform_name
     *
     * @param string $leadform_name
     * @return $this
     */
    public function setLeadformName($leadform_name)
    {
        $this->leadform_name = $leadform_name;

        return $this;
    }

    /**
     * Method to set the value of field leadform_country_code
     *
     * @param string $leadform_country_code
     * @return $this
     */
    public function setLeadformCountryCode($leadform_country_code)
    {
        $this->leadform_country_code = $leadform_country_code;

        return $this;
    }

    /**
     * Method to set the value of field leadform_number
     *
     * @param string $leadform_number
     * @return $this
     */
    public function setLeadformNumber($leadform_number)
    {
        $this->leadform_number = $leadform_number;

        return $this;
    }

    /**
     * Method to set the value of field leadform_email
     *
     * @param string $leadform_email
     * @return $this
     */
    public function setLeadformEmail($leadform_email)
    {
        $this->leadform_email = $leadform_email;

        return $this;
    }

    /**
     * Method to set the value of field leadform_content
     *
     * @param string $leadform_content
     * @return $this
     */
    public function setLeadformContent($leadform_content)
    {
        $this->leadform_content = $leadform_content;

        return $this;
    }

    /**
     * Method to set the value of field leadform_insert_time
     *
     * @param integer $leadform_insert_time
     * @return $this
     */
    public function setLeadformInsertTime($leadform_insert_time)
    {
        $this->leadform_insert_time = $leadform_insert_time;

        return $this;
    }

    /**
     * Returns the value of field leadform_id
     *
     * @return integer
     */
    public function getLeadformId()
    {
        return $this->leadform_id;
    }

    /**
     * Returns the value of field leadform_name
     *
     * @return string
     */
    public function getLeadformName()
    {
        return $this->leadform_name;
    }

    /**
     * Returns the value of field leadform_country_code
     *
     * @return string
     */
    public function getLeadformCountryCode()
    {
        return $this->leadform_country_code;
    }

    /**
     * Returns the value of field leadform_number
     *
     * @return string
     */
    public function getLeadformNumber()
    {
        return $this->leadform_number;
    }

    /**
     * Returns the value of field leadform_email
     *
     * @return string
     */
    public function getLeadformEmail()
    {
        return $this->leadform_email;
    }

    /**
     * Returns the value of field leadform_content
     *
     * @return string
     */
    public function getLeadformContent()
    {
        return $this->leadform_content;
    }

    /**
     * Returns the value of field leadform_insert_time
     *
     * @return integer
     */
    public function getLeadformInsertTime()
    {
        return $this->leadform_insert_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasOne(
            ['leadform_id'],
            'Indianimmigrationorg\Models\VisaActivity',
            ['activity_action_id'],
            [
                'alias' => 'activity',
                'params' => [
                    'conditions' => 'activity_controller = "leadform"',
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
        return 'visa_leadform';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLeadform[]|VisaLeadform
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLeadform
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLeadform
     */
    public static function findFirstById($id)
    {
        return self::findFirst([
            'leadform_id = :ID:',
            'bind'  => [
                'ID' => $id
            ]
        ]);
    }

}
