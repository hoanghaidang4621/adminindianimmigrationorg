<?php

namespace Indianimmigrationorg\Models;

class VisaCountryFee extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $country_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $visa_type_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $visa_fee;

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
     * Method to set the value of field visa_type_id
     *
     * @param integer $visa_type_id
     * @return $this
     */
    public function setVisaTypeId($visa_type_id)
    {
        $this->visa_type_id = $visa_type_id;

        return $this;
    }

    /**
     * Method to set the value of field visa_fee
     *
     * @param double $visa_fee
     * @return $this
     */
    public function setVisaFee($visa_fee)
    {
        $this->visa_fee = $visa_fee;

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
     * Returns the value of field visa_type_id
     *
     * @return integer
     */
    public function getVisaTypeId()
    {
        return $this->visa_type_id;
    }

    /**
     * Returns the value of field visa_fee
     *
     * @return double
     */
    public function getVisaFee()
    {
        return $this->visa_fee;
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
        return 'visa_country_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCountryFee[]|VisaCountryFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCountryFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
