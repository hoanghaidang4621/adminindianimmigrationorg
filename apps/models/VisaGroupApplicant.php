<?php

namespace Indianimmigrationorg\Models;

class VisaGroupApplicant extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $group_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $group_name;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $group_value;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $group_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $group_active;

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
     * Method to set the value of field group_name
     *
     * @param string $group_name
     * @return $this
     */
    public function setGroupName($group_name)
    {
        $this->group_name = $group_name;

        return $this;
    }

    /**
     * Method to set the value of field group_value
     *
     * @param integer $group_value
     * @return $this
     */
    public function setGroupValue($group_value)
    {
        $this->group_value = $group_value;

        return $this;
    }

    /**
     * Method to set the value of field group_order
     *
     * @param integer $group_order
     * @return $this
     */
    public function setGroupOrder($group_order)
    {
        $this->group_order = $group_order;

        return $this;
    }

    /**
     * Method to set the value of field group_active
     *
     * @param string $group_active
     * @return $this
     */
    public function setGroupActive($group_active)
    {
        $this->group_active = $group_active;

        return $this;
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
     * Returns the value of field group_name
     *
     * @return string
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Returns the value of field group_value
     *
     * @return integer
     */
    public function getGroupValue()
    {
        return $this->group_value;
    }

    /**
     * Returns the value of field group_order
     *
     * @return integer
     */
    public function getGroupOrder()
    {
        return $this->group_order;
    }

    /**
     * Returns the value of field group_active
     *
     * @return string
     */
    public function getGroupActive()
    {
        return $this->group_active;
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
        return 'visa_group_applicant';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGroupApplicant[]|VisaGroupApplicant
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGroupApplicant
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
