<?php

namespace Indianimmigrationorg\Models;

class VisaExtraServiceLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $service_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $service_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $service_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $service_description;

    /**
     * Method to set the value of field service_id
     *
     * @param integer $service_id
     * @return $this
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;

        return $this;
    }

    /**
     * Method to set the value of field service_lang_code
     *
     * @param string $service_lang_code
     * @return $this
     */
    public function setServiceLangCode($service_lang_code)
    {
        $this->service_lang_code = $service_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field service_name
     *
     * @param string $service_name
     * @return $this
     */
    public function setServiceName($service_name)
    {
        $this->service_name = $service_name;

        return $this;
    }

    /**
     * Method to set the value of field service_description
     *
     * @param string $service_description
     * @return $this
     */
    public function setServiceDescription($service_description)
    {
        $this->service_description = $service_description;

        return $this;
    }

    /**
     * Returns the value of field service_id
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * Returns the value of field service_lang_code
     *
     * @return string
     */
    public function getServiceLangCode()
    {
        return $this->service_lang_code;
    }

    /**
     * Returns the value of field service_name
     *
     * @return string
     */
    public function getServiceName()
    {
        return $this->service_name;
    }

    /**
     * Returns the value of field service_description
     *
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->service_description;
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
        return 'visa_extra_service_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaExtraServiceLang[]|VisaExtraServiceLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaExtraServiceLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
