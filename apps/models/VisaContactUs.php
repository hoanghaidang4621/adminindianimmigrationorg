<?php

namespace Indianimmigrationorg\Models;

use Phalcon\Mvc\Model;

class VisaContactUs extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $contact_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $contact_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $contact_number;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $contact_email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $contact_subject;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $contact_reason;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $contact_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $contact_file;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $contact_insert_time;

    /**
     * Method to set the value of field contact_id
     *
     * @param integer $contact_id
     * @return $this
     */
    public function setContactId($contact_id)
    {
        $this->contact_id = $contact_id;

        return $this;
    }

    /**
     * Method to set the value of field contact_name
     *
     * @param string $contact_name
     * @return $this
     */
    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    /**
     * Method to set the value of field contact_number
     *
     * @param string $contact_number
     * @return $this
     */
    public function setContactNumber($contact_number)
    {
        $this->contact_number = $contact_number;

        return $this;
    }

    /**
     * Method to set the value of field contact_email
     *
     * @param string $contact_email
     * @return $this
     */
    public function setContactEmail($contact_email)
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    /**
     * Method to set the value of field contact_subject
     *
     * @param string $contact_subject
     * @return $this
     */
    public function setContactSubject($contact_subject)
    {
        $this->contact_subject = $contact_subject;

        return $this;
    }

    /**
     * Method to set the value of field contact_reason
     *
     * @param string $contact_reason
     * @return $this
     */
    public function setContactReason($contact_reason)
    {
        $this->contact_reason = $contact_reason;

        return $this;
    }

    /**
     * Method to set the value of field contact_content
     *
     * @param string $contact_content
     * @return $this
     */
    public function setContactContent($contact_content)
    {
        $this->contact_content = $contact_content;

        return $this;
    }

    /**
     * Method to set the value of field contact_file
     *
     * @param string $contact_file
     * @return $this
     */
    public function setContactFile($contact_file)
    {
        $this->contact_file = $contact_file;

        return $this;
    }

    /**
     * Method to set the value of field contact_insert_time
     *
     * @param integer $contact_insert_time
     * @return $this
     */
    public function setContactInsertTime($contact_insert_time)
    {
        $this->contact_insert_time = $contact_insert_time;

        return $this;
    }

    /**
     * Returns the value of field contact_id
     *
     * @return integer
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * Returns the value of field contact_name
     *
     * @return string
     */
    public function getContactName()
    {
        return $this->contact_name;
    }

    /**
     * Returns the value of field contact_number
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contact_number;
    }

    /**
     * Returns the value of field contact_email
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }


    /**
     * Returns the value of field contact_subject
     *
     * @return string
     */
    public function getContactSubject()
    {
        return $this->contact_subject;
    }

    /**
     * Returns the value of field contact_reason
     *
     * @return string
     */
    public function getContactReason()
    {
        return $this->contact_reason;
    }

    /**
     * Returns the value of field contact_content
     *
     * @return string
     */
    public function getContactContent($langString = null)
    {
        if (is_string($this->contact_content) && is_string($langString)) {
            return str_replace('|||LANG|||', $langString, $this->contact_content);
        }
        return $this->contact_content;
    }

    /**
     * Returns the value of field contact_file
     *
     * @return string
     */
    public function getContactFile()
    {
        return $this->contact_file;
    }

    /**
     * Returns the value of field contact_insert_time
     *
     * @return integer
     */
    public function getContactInsertTime()
    {
        return $this->contact_insert_time;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasOne(
            ['contact_id'],
            'Indianimmigrationorg\Models\VisaActivity',
            ['activity_action_id'],
            [
                'alias' => 'activity',
                'params' => [
                    'conditions' => 'activity_controller = "contactus"',
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
        return 'visa_contactus';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OccContactus[]|OccContactus
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OccContactus
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findFirstById($contactus_id)
    {
        return self::findFirst([
            'contact_id = :contactusID:',
            'bind'  => [
                'contactusID' => $contactus_id
            ]
        ]);
    }
}
