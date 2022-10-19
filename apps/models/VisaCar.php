<?php

namespace Indianimmigrationorg\Models;

class VisaCar extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $car_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $car_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $car_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $car_active;

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
     * Method to set the value of field car_name
     *
     * @param string $car_name
     * @return $this
     */
    public function setCarName($car_name)
    {
        $this->car_name = $car_name;

        return $this;
    }

    /**
     * Method to set the value of field car_order
     *
     * @param integer $car_order
     * @return $this
     */
    public function setCarOrder($car_order)
    {
        $this->car_order = $car_order;

        return $this;
    }

    /**
     * Method to set the value of field car_active
     *
     * @param string $car_active
     * @return $this
     */
    public function setCarActive($car_active)
    {
        $this->car_active = $car_active;

        return $this;
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
     * Returns the value of field car_name
     *
     * @return string
     */
    public function getCarName()
    {
        return $this->car_name;
    }

    /**
     * Returns the value of field car_order
     *
     * @return integer
     */
    public function getCarOrder()
    {
        return $this->car_order;
    }

    /**
     * Returns the value of field car_active
     *
     * @return string
     */
    public function getCarActive()
    {
        return $this->car_active;
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
        return 'visa_car';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCar[]|VisaCar
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCar
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
