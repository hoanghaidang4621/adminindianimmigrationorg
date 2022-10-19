<?php

namespace Indianimmigrationorg\Models;

class VisaVisaFee extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $visa_type_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $group_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $visa_fee;

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
     * Returns the value of field visa_type_id
     *
     * @return integer
     */
    public function getVisaTypeId()
    {
        return $this->visa_type_id;
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
        return 'visa_visa_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaVisaFee[]|VisaVisaFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaVisaFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
