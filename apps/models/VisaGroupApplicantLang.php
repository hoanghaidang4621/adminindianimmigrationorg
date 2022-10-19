<?php

namespace Indianimmigrationorg\Models;

class VisaGroupApplicantLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $group_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $group_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $group_name;

    /**
     * Method to set the value of field group_id
     *
     * @param integer $group_id
     * @return $this
     */
    public function setGroupId($group_id)
    {
        $this->group_id = $group_id;

        return $this;
    }

    /**
     * Method to set the value of field group_lang_code
     *
     * @param string $group_lang_code
     * @return $this
     */
    public function setGroupLangCode($group_lang_code)
    {
        $this->group_lang_code = $group_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field group_name
     *
     * @param string $group_name
     * @return $this
     */
    public function setGroupName($group_name)
    {
        $this->group_name = $group_name;

        return $this;
    }

    /**
     * Returns the value of field group_id
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Returns the value of field group_lang_code
     *
     * @return string
     */
    public function getGroupLangCode()
    {
        return $this->group_lang_code;
    }

    /**
     * Returns the value of field group_name
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Initialize method for model.
     */
//    public function initialize()
//    {
//        $this->setSchema("indiaimmigration_in_lang");
//    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_group_applicant_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGroupApplicantLang[]|VisaGroupApplicantLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGroupApplicantLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
