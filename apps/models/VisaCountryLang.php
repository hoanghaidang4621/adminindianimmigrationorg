<?php

namespace Indianimmigrationorg\Models;

class VisaCountryLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $country_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $country_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $country_name;

    /**
     * Method to set the value of field country_id
     *
     * @param integer $country_id
     * @return $this
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * Method to set the value of field country_lang_code
     *
     * @param string $country_lang_code
     * @return $this
     */
    public function setCountryLangCode($country_lang_code)
    {
        $this->country_lang_code = $country_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field country_name
     *
     * @param string $country_name
     * @return $this
     */
    public function setCountryName($country_name)
    {
        $this->country_name = $country_name;

        return $this;
    }

    /**
     * Returns the value of field country_id
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Returns the value of field country_lang_code
     *
     * @return string
     */
    public function getCountryLangCode()
    {
        return $this->country_lang_code;
    }

    /**
     * Returns the value of field country_name
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->country_name;
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
        return 'visa_country_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCountryLang[]|VisaCountryLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCountryLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findById($id)
    {
        return self::find(array(
            "country_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }

}
