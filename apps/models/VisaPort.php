<?php

namespace Indianimmigrationorg\Models;

class VisaPort extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $port_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $port_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $port_type_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $port_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $port_active;

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
     * Method to set the value of field port_name
     *
     * @param string $port_name
     * @return $this
     */
    public function setPortName($port_name)
    {
        $this->port_name = $port_name;

        return $this;
    }

    /**
     * Method to set the value of field port_type_id
     *
     * @param integer $port_type_id
     * @return $this
     */
    public function setPortTypeId($port_type_id)
    {
        $this->port_type_id = $port_type_id;

        return $this;
    }

    /**
     * Method to set the value of field port_order
     *
     * @param integer $port_order
     * @return $this
     */
    public function setPortOrder($port_order)
    {
        $this->port_order = $port_order;

        return $this;
    }

    /**
     * Method to set the value of field port_active
     *
     * @param string $port_active
     * @return $this
     */
    public function setPortActive($port_active)
    {
        $this->port_active = $port_active;

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
     * Returns the value of field port_name
     *
     * @return string
     */
    public function getPortName()
    {
        return $this->port_name;
    }

    /**
     * Returns the value of field port_type_id
     *
     * @return integer
     */
    public function getPortTypeId()
    {
        return $this->port_type_id;
    }

    /**
     * Returns the value of field port_order
     *
     * @return integer
     */
    public function getPortOrder()
    {
        return $this->port_order;
    }

    /**
     * Returns the value of field port_active
     *
     * @return string
     */
    public function getPortActive()
    {
        return $this->port_active;
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
        return 'visa_port';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPort[]|VisaPort
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPort
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
