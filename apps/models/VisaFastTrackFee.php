<?php

namespace Indianimmigrationorg\Models;

class VisaFastTrackFee extends BaseModel
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
    protected $group_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $fast_check_fee;

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
     * Method to set the value of field fast_check_fee
     *
     * @param double $fast_check_fee
     * @return $this
     */
    public function setFastCheckFee($fast_check_fee)
    {
        $this->fast_check_fee = $fast_check_fee;

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
     * Returns the value of field group_id
     *
     * @return integer
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Returns the value of field fast_check_fee
     *
     * @return double
     */
    public function getFastCheckFee()
    {
        return $this->fast_check_fee;
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
        return 'visa_fast_track_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaFastTrackFee[]|VisaFastTrackFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaFastTrackFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
