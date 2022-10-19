<?php
namespace Indianimmigrationorg\Models;

class VisaOrderDetail extends BaseModel
{

    /**
     *
     * @var integer
     */
    protected $order_detail_id;

    /**
     *
     * @var integer
     */
    protected $order_id;

    /**
     *
     * @var string
     */
    protected $order_service_id;

    /**
     *
     * @var string
     */
    protected $order_service_name;

    /**
     *
     * @var double
     */
    protected $order_service_fee;

    /**
     * Method to set the value of field order_detail_id
     *
     * @param integer $order_detail_id
     * @return $this
     */
    public function setOrderDetailId($order_detail_id)
    {
        $this->order_detail_id = $order_detail_id;

        return $this;
    }

    /**
     * Method to set the value of field order_id
     *
     * @param integer $order_id
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * Method to set the value of field order_service_id
     *
     * @param integer $order_service_id
     * @return $this
     */
    public function setOrderServiceId($order_service_id)
    {
        $this->order_service_id = $order_service_id;

        return $this;
    }

    /**
     * Method to set the value of field order_service_name
     *
     * @param string $order_service_name
     * @return $this
     */
    public function setOrderServiceName($order_service_name)
    {
        $this->order_service_name = $order_service_name;

        return $this;
    }

    /**
     * Method to set the value of field order_service_fee
     *
     * @param double $order_service_fee
     * @return $this
     */
    public function setOrderServiceFee($order_service_fee)
    {
        $this->order_service_fee = $order_service_fee;

        return $this;
    }

    /**
     * Returns the value of field order_detail_id
     *
     * @return integer
     */
    public function getOrderDetailId()
    {
        return $this->order_detail_id;
    }

    /**
     * Returns the value of field order_id
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Returns the value of field order_service_id
     *
     * @return string
     */
    public function getOrderServiceId()
    {
        return $this->order_service_id;
    }

    /**
     * Returns the value of field order_service_name
     *
     * @return string
     */
    public function getOrderServiceName()
    {
        return $this->order_service_name;
    }

    /**
     * Returns the value of field order_service_fee
     *
     * @return double
     */
    public function getOrderServiceFee()
    {
        return $this->order_service_fee;
    }

    /**
     * Initialize method for model.
     */
//    public function initialize()
//    {
//        $this->setSchema("indianimmigrationorgnew");
//        $this->setSource("visa_order_detail");
//    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_order_detail';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderDetail[]|VisaOrderDetail|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderDetail|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
