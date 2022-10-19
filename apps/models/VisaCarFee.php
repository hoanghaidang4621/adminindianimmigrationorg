<?php

namespace Indianimmigrationorg\Models;

class VisaCarFee extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $port_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $car_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $car_fee;

    /**
     * Method to set the value of field port_id
     *
     * @param integer $port_id
     * @return $this
     */
    public function setPortId($port_id)
    {
        $this->port_id = $port_id;

        return $this;
    }

    /**
     * Method to set the value of field car_id
     *
     * @param integer $car_id
     * @return $this
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;

        return $this;
    }

    /**
     * Method to set the value of field car_fee
     *
     * @param double $car_fee
     * @return $this
     */
    public function setCarFee($car_fee)
    {
        $this->car_fee = $car_fee;

        return $this;
    }

    /**
     * Returns the value of field port_id
     *
     * @return integer
     */
    public function getPortId()
    {
        return $this->port_id;
    }

    /**
     * Returns the value of field car_id
     *
     * @return integer
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * Returns the value of field car_fee
     *
     * @return double
     */
    public function getCarFee()
    {
        return $this->car_fee;
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
        return 'visa_car_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCarFee[]|VisaCarFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCarFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
