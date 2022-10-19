<?php

namespace Visacorp\Models;

class TypeUser extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $typeuser_id;

    /**
     *
     * @var string
     */
    protected $typeuser_name;

    /**
     *
     * @var integer
     */
    protected $typeuser_from_order;

    /**
     *
     * @var integer
     */
    protected $typeuser_to_order;

    /**
     *
     * @var double
     */
    protected $typeuser_rate;

    /**
     *
     * @var string
     */
    protected $typeuser_active;

    /**
     * Method to set the value of field typeuser_id
     *
     * @param integer $typeuser_id
     * @return $this
     */
    public function setTypeuserId($typeuser_id)
    {
        $this->typeuser_id = $typeuser_id;

        return $this;
    }

    /**
     * Method to set the value of field typeuser_name
     *
     * @param string $typeuser_name
     * @return $this
     */
    public function setTypeuserName($typeuser_name)
    {
        $this->typeuser_name = $typeuser_name;

        return $this;
    }

    /**
     * Method to set the value of field typeuser_from_order
     *
     * @param integer $typeuser_from_order
     * @return $this
     */
    public function setTypeuserFromOrder($typeuser_from_order)
    {
        $this->typeuser_from_order = $typeuser_from_order;

        return $this;
    }

    /**
     * Method to set the value of field typeuser_to_order
     *
     * @param integer $typeuser_to_order
     * @return $this
     */
    public function setTypeuserToOrder($typeuser_to_order)
    {
        $this->typeuser_to_order = $typeuser_to_order;

        return $this;
    }

    /**
     * Method to set the value of field typeuser_rate
     *
     * @param double $typeuser_rate
     * @return $this
     */
    public function setTypeuserRate($typeuser_rate)
    {
        $this->typeuser_rate = $typeuser_rate;

        return $this;
    }

    /**
     * Method to set the value of field typeuser_active
     *
     * @param string $typeuser_active
     * @return $this
     */
    public function setTypeuserActive($typeuser_active)
    {
        $this->typeuser_active = $typeuser_active;

        return $this;
    }

    /**
     * Returns the value of field typeuser_id
     *
     * @return integer
     */
    public function getTypeuserId()
    {
        return $this->typeuser_id;
    }

    /**
     * Returns the value of field typeuser_name
     *
     * @return string
     */
    public function getTypeuserName()
    {
        return $this->typeuser_name;
    }

    /**
     * Returns the value of field typeuser_from_order
     *
     * @return integer
     */
    public function getTypeuserFromOrder()
    {
        return $this->typeuser_from_order;
    }

    /**
     * Returns the value of field typeuser_to_order
     *
     * @return integer
     */
    public function getTypeuserToOrder()
    {
        return $this->typeuser_to_order;
    }

    /**
     * Returns the value of field typeuser_rate
     *
     * @return double
     */
    public function getTypeuserRate()
    {
        return $this->typeuser_rate;
    }

    /**
     * Returns the value of field typeuser_active
     *
     * @return string
     */
    public function getTypeuserActive()
    {
        return $this->typeuser_active;
    }
    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('db_visacorp');
        $config = $this->getDI()->get('db_visacorp')->getDescriptor();
        $this->setSchema($config['schema']);
    }
    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'type_user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TypeUser[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TypeUser
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function findFirstById($id){
        return self::findFirst([
            'typeuser_id = :ID:',
            'bind' => ['ID' => $id]
        ]);
    }

}
