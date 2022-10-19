<?php

namespace Indianimmigrationorg\Models;

class VisaLocation extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $location_id;

    /**
     *
     * @var string
     * @Column(type="string", length=2, nullable=false)
     */
    protected $location_country_code;

    /**
     *
     * @var string
     * @Column(type="string", length=5, nullable=false)
     */
    protected $location_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $location_schema_contactpoint;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $location_schema_social;

    /**
     *
     * @var string
     * @Column(type="string", length=5, nullable=true)
     */
    protected $location_alternate_hreflang;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $location_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $location_active;

    /**
     * Method to set the value of field location_id
     *
     * @param integer $location_id
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;

        return $this;
    }

    /**
     * Method to set the value of field location_country_code
     *
     * @param string $location_country_code
     * @return $this
     */
    public function setLocationCountryCode($location_country_code)
    {
        $this->location_country_code = $location_country_code;

        return $this;
    }

    /**
     * Method to set the value of field location_lang_code
     *
     * @param string $location_lang_code
     * @return $this
     */
    public function setLocationLangCode($location_lang_code)
    {
        $this->location_lang_code = $location_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field location_schema_contactpoint
     *
     * @param string $location_schema_contactpoint
     * @return $this
     */
    public function setLocationSchemaContactpoint($location_schema_contactpoint)
    {
        $this->location_schema_contactpoint = $location_schema_contactpoint;

        return $this;
    }

    /**
     * Method to set the value of field location_schema_social
     *
     * @param string $location_schema_social
     * @return $this
     */
    public function setLocationSchemaSocial($location_schema_social)
    {
        $this->location_schema_social = $location_schema_social;

        return $this;
    }

    /**
     * Method to set the value of field location_alternate_hreflang
     *
     * @param string $location_alternate_hreflang
     * @return $this
     */
    public function setLocationAlternateHreflang($location_alternate_hreflang)
    {
        $this->location_alternate_hreflang = $location_alternate_hreflang;

        return $this;
    }

    /**
     * Method to set the value of field location_order
     *
     * @param integer $location_order
     * @return $this
     */
    public function setLocationOrder($location_order)
    {
        $this->location_order = $location_order;

        return $this;
    }

    /**
     * Method to set the value of field location_active
     *
     * @param string $location_active
     * @return $this
     */
    public function setLocationActive($location_active)
    {
        $this->location_active = $location_active;

        return $this;
    }

    /**
     * Returns the value of field location_id
     *
     * @return integer
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * Returns the value of field location_country_code
     *
     * @return string
     */
    public function getLocationCountryCode()
    {
        return $this->location_country_code;
    }

    /**
     * Returns the value of field location_lang_code
     *
     * @return string
     */
    public function getLocationLangCode()
    {
        return $this->location_lang_code;
    }

    /**
     * Returns the value of field location_schema_contactpoint
     *
     * @return string
     */
    public function getLocationSchemaContactpoint()
    {
        return $this->location_schema_contactpoint;
    }

    /**
     * Returns the value of field location_schema_social
     *
     * @return string
     */
    public function getLocationSchemaSocial()
    {
        return $this->location_schema_social;
    }

    /**
     * Returns the value of field location_alternate_hreflang
     *
     * @return string
     */
    public function getLocationAlternateHreflang()
    {
        return $this->location_alternate_hreflang;
    }

    /**
     * Returns the value of field location_order
     *
     * @return integer
     */
    public function getLocationOrder()
    {
        return $this->location_order;
    }

    /**
     * Returns the value of field location_active
     *
     * @return string
     */
    public function getLocationActive()
    {
        return $this->location_active;
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
        return 'visa_location';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLocation[]|VisaLocation
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaLocation
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
