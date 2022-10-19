<?php

namespace Indianimmigrationorg\Models;

class VisaPortTypeLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $type_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $type_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $type_name;

    /**
     * Method to set the value of field type_id
     *
     * @param integer $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Method to set the value of field type_lang_code
     *
     * @param string $type_lang_code
     * @return $this
     */
    public function setTypeLangCode($type_lang_code)
    {
        $this->type_lang_code = $type_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field type_name
     *
     * @param string $type_name
     * @return $this
     */
    public function setTypeName($type_name)
    {
        $this->type_name = $type_name;

        return $this;
    }

    /**
     * Returns the value of field type_id
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Returns the value of field type_lang_code
     *
     * @return string
     */
    public function getTypeLangCode()
    {
        return $this->type_lang_code;
    }

    /**
     * Returns the value of field type_name
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->type_name;
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
        return 'visa_port_type_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPortTypeLang[]|VisaPortTypeLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPortTypeLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
