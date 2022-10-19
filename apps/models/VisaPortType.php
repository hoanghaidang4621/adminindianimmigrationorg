<?php

namespace Indianimmigrationorg\Models;

class VisaPortType extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $type_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $type_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $type_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $type_active;

    /**
     * Method to set the value of field type_id
     *
     * @param integer $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Method to set the value of field type_name
     *
     * @param string $type_name
     * @return $this
     */
    public function setTypeName($type_name)
    {
        $this->type_name = $type_name;

        return $this;
    }

    /**
     * Method to set the value of field type_order
     *
     * @param integer $type_order
     * @return $this
     */
    public function setTypeOrder($type_order)
    {
        $this->type_order = $type_order;

        return $this;
    }

    /**
     * Method to set the value of field type_active
     *
     * @param string $type_active
     * @return $this
     */
    public function setTypeActive($type_active)
    {
        $this->type_active = $type_active;

        return $this;
    }

    /**
     * Returns the value of field type_id
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Returns the value of field type_name
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * Returns the value of field type_order
     *
     * @return integer
     */
    public function getTypeOrder()
    {
        return $this->type_order;
    }

    /**
     * Returns the value of field type_active
     *
     * @return string
     */
    public function getTypeActive()
    {
        return $this->type_active;
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
        return 'visa_port_type';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPortType[]|VisaPortType
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPortType
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
