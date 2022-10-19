<?php

namespace Indianimmigrationorg\Models;

class VisaProcessingFee extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $processing_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $processing_name;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $processing_fee;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $processing_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $processing_active;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $processing_date;

    /**
     * Method to set the value of field processing_id
     *
     * @param integer $processing_id
     * @return $this
     */
    public function setProcessingId($processing_id)
    {
        $this->processing_id = $processing_id;

        return $this;
    }

    /**
     * Method to set the value of field processing_name
     *
     * @param string $processing_name
     * @return $this
     */
    public function setProcessingName($processing_name)
    {
        $this->processing_name = $processing_name;

        return $this;
    }

    /**
     * Method to set the value of field processing_fee
     *
     * @param double $processing_fee
     * @return $this
     */
    public function setProcessingFee($processing_fee)
    {
        $this->processing_fee = $processing_fee;

        return $this;
    }

    /**
     * Method to set the value of field processing_order
     *
     * @param integer $processing_order
     * @return $this
     */
    public function setProcessingOrder($processing_order)
    {
        $this->processing_order = $processing_order;

        return $this;
    }

    /**
     * Method to set the value of field processing_active
     *
     * @param string $processing_active
     * @return $this
     */
    public function setProcessingActive($processing_active)
    {
        $this->processing_active = $processing_active;

        return $this;
    }

    /**
     * Method to set the value of field processing_date
     *
     * @param integer $processing_date
     * @return $this
     */
    public function setProcessingDate($processing_date)
    {
        $this->processing_date = $processing_date;

        return $this;
    }

    /**
     * Returns the value of field processing_id
     *
     * @return integer
     */
    public function getProcessingId()
    {
        return $this->processing_id;
    }

    /**
     * Returns the value of field processing_name
     *
     * @return string
     */
    public function getProcessingName()
    {
        return $this->processing_name;
    }

    /**
     * Returns the value of field processing_fee
     *
     * @return double
     */
    public function getProcessingFee()
    {
        return $this->processing_fee;
    }

    /**
     * Returns the value of field processing_order
     *
     * @return integer
     */
    public function getProcessingOrder()
    {
        return $this->processing_order;
    }

    /**
     * Returns the value of field processing_active
     *
     * @return string
     */
    public function getProcessingActive()
    {
        return $this->processing_active;
    }

    /**
     * Returns the value of field processing_date
     *
     * @return integer
     */
    public function getProcessingDate()
    {
        return $this->processing_date;
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
        return 'visa_processing_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaProcessingFee[]|VisaProcessingFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaProcessingFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
