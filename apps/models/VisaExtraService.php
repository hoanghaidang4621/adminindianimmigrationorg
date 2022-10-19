<?php

namespace Indianimmigrationorg\Models;

class VisaExtraService extends BaseModel
{
    const SERVICE_TRAVEL_SIM = 321;
    const SERVICE_TRAVEL_INSURANCE = 322;
    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $service_id;

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
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $service_price;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $service_listed_price;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $service_discount;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $service_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $service_active;

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
     * Method to set the value of field service_price
     *
     * @param double $service_price
     * @return $this
     */
    public function setServicePrice($service_price)
    {
        $this->service_price = $service_price;

        return $this;
    }

    /**
     * Method to set the value of field service_listed_price
     *
     * @param double $service_listed_price
     * @return $this
     */
    public function setServiceListedPrice($service_listed_price)
    {
        $this->service_listed_price = $service_listed_price;

        return $this;
    }

    /**
     * Method to set the value of field service_discount
     *
     * @param string $service_discount
     * @return $this
     */
    public function setServiceDiscount($service_discount)
    {
        $this->service_discount = $service_discount;

        return $this;
    }

    /**
     * Method to set the value of field service_order
     *
     * @param integer $service_order
     * @return $this
     */
    public function setServiceOrder($service_order)
    {
        $this->service_order = $service_order;

        return $this;
    }

    /**
     * Method to set the value of field service_active
     *
     * @param string $service_active
     * @return $this
     */
    public function setServiceActive($service_active)
    {
        $this->service_active = $service_active;

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
     * Returns the value of field service_price
     *
     * @return double
     */
    public function getServicePrice()
    {
        return $this->service_price;
    }

    /**
     * Returns the value of field service_listed_price
     *
     * @return double
     */
    public function getServiceListedPrice()
    {
        return $this->service_listed_price;
    }

    /**
     * Returns the value of field service_discount
     *
     * @return string
     */
    public function getServiceDiscount()
    {
        return $this->service_discount;
    }

    /**
     * Returns the value of field service_order
     *
     * @return integer
     */
    public function getServiceOrder()
    {
        return $this->service_order;
    }

    /**
     * Returns the value of field service_active
     *
     * @return string
     */
    public function getServiceActive()
    {
        return $this->service_active;
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
        return 'visa_extra_service';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaExtraService[]|VisaExtraService
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaExtraService
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
