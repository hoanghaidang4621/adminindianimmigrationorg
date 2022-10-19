<?php

namespace Indianimmigrationorg\Models;

use Phalcon\Di;

class VisaReceipt extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $receipt_id;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $receipt_order_id;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $receipt_pay_date;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $receipt_pay_method;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $receipt_total;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $receipt_transation_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $receipt_transation_date;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $receipt_creditcard;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $receipt_creditname;

    /**
     *
     * @var string
     * @Column(type="string", length=3, nullable=true)
     */
    protected $receipt_currency;

    /**
     *
     * @var double
     * @Column(type="double", nullable=true)
     */
    protected $receipt_exrate;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=true)
     */
    protected $receipt_exrate_date;

    /**
     * Method to set the value of field receipt_id
     *
     * @param integer $receipt_id
     * @return $this
     */
    public function setReceiptId($receipt_id)
    {
        $this->receipt_id = $receipt_id;

        return $this;
    }

    /**
     * Method to set the value of field receipt_order_id
     *
     * @param integer $receipt_order_id
     * @return $this
     */
    public function setReceiptOrderId($receipt_order_id)
    {
        $this->receipt_order_id = $receipt_order_id;

        return $this;
    }

    /**
     * Method to set the value of field receipt_pay_date
     *
     * @param integer $receipt_pay_date
     * @return $this
     */
    public function setReceiptPayDate($receipt_pay_date)
    {
        $this->receipt_pay_date = $receipt_pay_date;

        return $this;
    }

    /**
     * Method to set the value of field receipt_pay_method
     *
     * @param string $receipt_pay_method
     * @return $this
     */
    public function setReceiptPayMethod($receipt_pay_method)
    {
        $this->receipt_pay_method = $receipt_pay_method;

        return $this;
    }

    /**
     * Method to set the value of field receipt_total
     *
     * @param double $receipt_total
     * @return $this
     */
    public function setReceiptTotal($receipt_total)
    {
        $this->receipt_total = $receipt_total;

        return $this;
    }

    /**
     * Method to set the value of field receipt_transation_id
     *
     * @param string $receipt_transation_id
     * @return $this
     */
    public function setReceiptTransationId($receipt_transation_id)
    {
        $this->receipt_transation_id = $receipt_transation_id;

        return $this;
    }

    /**
     * Method to set the value of field receipt_transation_date
     *
     * @param string $receipt_transation_date
     * @return $this
     */
    public function setReceiptTransationDate($receipt_transation_date)
    {
        $this->receipt_transation_date = $receipt_transation_date;

        return $this;
    }

    /**
     * Method to set the value of field receipt_creditcard
     *
     * @param string $receipt_creditcard
     * @return $this
     */
    public function setReceiptCreditcard($receipt_creditcard)
    {
        $this->receipt_creditcard = $receipt_creditcard;

        return $this;
    }

    /**
     * Method to set the value of field receipt_creditname
     *
     * @param string $receipt_creditname
     * @return $this
     */
    public function setReceiptCreditname($receipt_creditname)
    {
        $this->receipt_creditname = $receipt_creditname;

        return $this;
    }

    /**
     * Method to set the value of field receipt_currency
     *
     * @param string $receipt_currency
     * @return $this
     */
    public function setReceiptCurrency($receipt_currency)
    {
        $this->receipt_currency = $receipt_currency;

        return $this;
    }

    /**
     * Method to set the value of field receipt_exrate
     *
     * @param double $receipt_exrate
     * @return $this
     */
    public function setReceiptExrate($receipt_exrate)
    {
        $this->receipt_exrate = $receipt_exrate;

        return $this;
    }

    /**
     * Method to set the value of field receipt_exrate_date
     *
     * @param integer $receipt_exrate_date
     * @return $this
     */
    public function setReceiptExrateDate($receipt_exrate_date)
    {
        $this->receipt_exrate_date = $receipt_exrate_date;

        return $this;
    }

    /**
     * Returns the value of field receipt_id
     *
     * @return integer
     */
    public function getReceiptId()
    {
        return $this->receipt_id;
    }

    /**
     * Returns the value of field receipt_order_id
     *
     * @return integer
     */
    public function getReceiptOrderId()
    {
        return $this->receipt_order_id;
    }

    /**
     * Returns the value of field receipt_pay_date
     *
     * @return integer
     */
    public function getReceiptPayDate()
    {
        return $this->receipt_pay_date;
    }

    /**
     * Returns the value of field receipt_pay_method
     *
     * @return string
     */
    public function getReceiptPayMethod()
    {
        return $this->receipt_pay_method;
    }

    /**
     * Returns the value of field receipt_total
     *
     * @return double
     */
    public function getReceiptTotal()
    {
        return $this->receipt_total;
    }

    /**
     * Returns the value of field receipt_transation_id
     *
     * @return string
     */
    public function getReceiptTransationId()
    {
        return $this->receipt_transation_id;
    }

    /**
     * Returns the value of field receipt_transation_date
     *
     * @return string
     */
    public function getReceiptTransationDate()
    {
        return $this->receipt_transation_date;
    }

    /**
     * Returns the value of field receipt_creditcard
     *
     * @return string
     */
    public function getReceiptCreditcard()
    {
        return $this->receipt_creditcard;
    }

    /**
     * Returns the value of field receipt_creditname
     *
     * @return string
     */
    public function getReceiptCreditname()
    {
        return $this->receipt_creditname;
    }

    /**
     * Returns the value of field receipt_currency
     *
     * @return string
     */
    public function getReceiptCurrency()
    {
        return $this->receipt_currency;
    }

    /**
     * Returns the value of field receipt_exrate
     *
     * @return double
     */
    public function getReceiptExrate()
    {
        return $this->receipt_exrate;
    }

    /**
     * Returns the value of field receipt_exrate_date
     *
     * @return integer
     */
    public function getReceiptExrateDate()
    {
        return $this->receipt_exrate_date;
    }

    /**
     * Initialize method for model.
     */
//    public function initialize()
//    {
//        $this->setSchema("indianimmigration_org_new");
//    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_receipt';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaReceipt[]|VisaReceipt
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaReceipt
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getFormattedId()
    {
        $di = Di::getDefault();
        $my = $di->get('my');
        return $my->formatReceiptID($this->getReceiptPayDate(), $this->getReceiptID(), $this->getReceiptOrderId());
    }
}
