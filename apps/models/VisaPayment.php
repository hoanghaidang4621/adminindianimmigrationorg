<?php
namespace Indianimmigrationorg\Models;

use Phalcon\Di;

class VisaPayment extends BaseModel
{

    const METHOD_PAYPAL_DIRECT = 'Credit/Debit Card (Paypal)';
    const METHOD_2C2P_DIRECT        = 'Credit/Debit Card (2C2P)';
    const METHOD_CYBERSOURCE   = 'Credit/Debit Card (CyberSource)';
    const METHOD_AMERICAN_EXPRESS  = 'Credit/Debit Card (Amex)';
    const METHOD_STRIPE        = 'Credit/Debit Card (Stripe)';
    const METHOD_PAYPAL        = 'Paypal';

    const PAYMENT_CYBERSOURCE = 'credit_debit_card';
    const PAYMENT_PAYPAL_DIRECT = 'credit_debit_card2';
    const PAYMENT_STRIPE = 'credit_debit_card3';
    const PAYMENT_2C2P_DIRECT       = 'credit_debit_card4';
    const PAYMENT_PAYPAL = 'checkout';
    const PAYMENT_AMERICAN_EXPRESS = 'amex_card';

    const STATUS_SUCCESS = 'Success';
    const STATUS_FAIL = 'Fail';
    const STATUS_PENDING = 'Pending';
    const STATUS_PROCESSING = 'Processing';

    /**
     *
     * @var integer
     */
    protected $payment_id;

    /**
     *
     * @var integer
     */
    protected $payment_user_id;

    /**
     *
     * @var double
     */
    protected $payment_amount;

    /**
     *
     * @var string
     */
    protected $payment_for;

    /**
     *
     * @var string
     */
    protected $payment_note;

    /**
     *
     * @var string
     */
    protected $payment_method;

    /**
     *
     * @var string
     */
    protected $payment_cardtype;

    /**
     *
     * @var string
     */
    protected $payment_isenrolled3d;

    /**
     *
     * @var string
     */
    protected $payment_ispassed3d;

    /**
     *
     * @var integer
     */
    protected $payment_insertdate;

    /**
     *
     * @var integer
     */
    protected $payment_date;

    /**
     *
     * @var string
     */
    protected $payment_status;

    /**
     *
     * @var string
     */
    protected $payment_transation_id;

    /**
     *
     * @var string
     */
    protected $payment_transation_date;

    /**
     *
     * @var string
     */
    protected $payment_creditcard;

    /**
     *
     * @var string
     */
    protected $payment_creditname;

    /**
     *
     * @var string
     */
    protected $payment_fail_reason;

    /**
     *
     * @var string
     */
    protected $payment_currency;

    /**
     *
     * @var double
     */
    protected $payment_exrate;

    /**
     *
     * @var integer
     */
    protected $payment_exrate_date;

    /**
     *
     * @var integer
     */
    protected $payment_user_local_id;

    /**
     *
     * @var integer
     */
    protected $payment_user_service_id;

    /**
     *
     * @var string
     */
    protected $payment_whatsapp_success_id;

    /**
     *
     * @var string
     */
    protected $payment_whatsapp_success_status;

    /**
     *
     * @var string
     */
    protected $payment_whatsapp_success_error;

    /**
     *
     * @var integer
     */
    protected $payment_whatsapp_success_date;

    /**
     * Method to set the value of field payment_id
     *
     * @param integer $payment_id
     * @return $this
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_user_id
     *
     * @param integer $payment_user_id
     * @return $this
     */
    public function setPaymentUserId($payment_user_id)
    {
        $this->payment_user_id = $payment_user_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_amount
     *
     * @param double $payment_amount
     * @return $this
     */
    public function setPaymentAmount($payment_amount)
    {
        $this->payment_amount = $payment_amount;

        return $this;
    }

    /**
     * Method to set the value of field payment_for
     *
     * @param string $payment_for
     * @return $this
     */
    public function setPaymentFor($payment_for)
    {
        $this->payment_for = $payment_for;

        return $this;
    }

    /**
     * Method to set the value of field payment_note
     *
     * @param string $payment_note
     * @return $this
     */
    public function setPaymentNote($payment_note)
    {
        $this->payment_note = $payment_note;

        return $this;
    }

    /**
     * Method to set the value of field payment_method
     *
     * @param string $payment_method
     * @return $this
     */
    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    /**
     * Method to set the value of field payment_cardtype
     *
     * @param string $payment_cardtype
     * @return $this
     */
    public function setPaymentCardtype($payment_cardtype)
    {
        $this->payment_cardtype = $payment_cardtype;

        return $this;
    }

    /**
     * Method to set the value of field payment_isenrolled3d
     *
     * @param string $payment_isenrolled3d
     * @return $this
     */
    public function setPaymentIsenrolled3d($payment_isenrolled3d)
    {
        $this->payment_isenrolled3d = $payment_isenrolled3d;

        return $this;
    }

    /**
     * Method to set the value of field payment_ispassed3d
     *
     * @param string $payment_ispassed3d
     * @return $this
     */
    public function setPaymentIspassed3d($payment_ispassed3d)
    {
        $this->payment_ispassed3d = $payment_ispassed3d;

        return $this;
    }

    /**
     * Method to set the value of field payment_insertdate
     *
     * @param integer $payment_insertdate
     * @return $this
     */
    public function setPaymentInsertdate($payment_insertdate)
    {
        $this->payment_insertdate = $payment_insertdate;

        return $this;
    }

    /**
     * Method to set the value of field payment_date
     *
     * @param integer $payment_date
     * @return $this
     */
    public function setPaymentDate($payment_date)
    {
        $this->payment_date = $payment_date;

        return $this;
    }

    /**
     * Method to set the value of field payment_status
     *
     * @param string $payment_status
     * @return $this
     */
    public function setPaymentStatus($payment_status)
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    /**
     * Method to set the value of field payment_transation_id
     *
     * @param string $payment_transation_id
     * @return $this
     */
    public function setPaymentTransationId($payment_transation_id)
    {
        $this->payment_transation_id = $payment_transation_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_transation_date
     *
     * @param string $payment_transation_date
     * @return $this
     */
    public function setPaymentTransationDate($payment_transation_date)
    {
        $this->payment_transation_date = $payment_transation_date;

        return $this;
    }

    /**
     * Method to set the value of field payment_creditcard
     *
     * @param string $payment_creditcard
     * @return $this
     */
    public function setPaymentCreditcard($payment_creditcard)
    {
        $this->payment_creditcard = $payment_creditcard;

        return $this;
    }

    /**
     * Method to set the value of field payment_creditname
     *
     * @param string $payment_creditname
     * @return $this
     */
    public function setPaymentCreditname($payment_creditname)
    {
        $this->payment_creditname = $payment_creditname;

        return $this;
    }

    /**
     * Method to set the value of field payment_fail_reason
     *
     * @param string $payment_fail_reason
     * @return $this
     */
    public function setPaymentFailReason($payment_fail_reason)
    {
        $this->payment_fail_reason = $payment_fail_reason;

        return $this;
    }

    /**
     * Method to set the value of field payment_currency
     *
     * @param string $payment_currency
     * @return $this
     */
    public function setPaymentCurrency($payment_currency)
    {
        $this->payment_currency = $payment_currency;

        return $this;
    }

    /**
     * Method to set the value of field payment_exrate
     *
     * @param double $payment_exrate
     * @return $this
     */
    public function setPaymentExrate($payment_exrate)
    {
        $this->payment_exrate = $payment_exrate;

        return $this;
    }

    /**
     * Method to set the value of field payment_exrate_date
     *
     * @param integer $payment_exrate_date
     * @return $this
     */
    public function setPaymentExrateDate($payment_exrate_date)
    {
        $this->payment_exrate_date = $payment_exrate_date;

        return $this;
    }

    /**
     * Method to set the value of field payment_user_local_id
     *
     * @param integer $payment_user_local_id
     * @return $this
     */
    public function setPaymentUserLocalId($payment_user_local_id)
    {
        $this->payment_user_local_id = $payment_user_local_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_user_service_id
     *
     * @param integer $payment_user_service_id
     * @return $this
     */
    public function setPaymentUserServiceId($payment_user_service_id)
    {
        $this->payment_user_service_id = $payment_user_service_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_whatsapp_success_id
     *
     * @param string $payment_whatsapp_success_id
     * @return $this
     */
    public function setPaymentWhatsappSuccessId($payment_whatsapp_success_id)
    {
        $this->payment_whatsapp_success_id = $payment_whatsapp_success_id;

        return $this;
    }

    /**
     * Method to set the value of field payment_whatsapp_success_status
     *
     * @param string $payment_whatsapp_success_status
     * @return $this
     */
    public function setPaymentWhatsappSuccessStatus($payment_whatsapp_success_status)
    {
        $this->payment_whatsapp_success_status = $payment_whatsapp_success_status;

        return $this;
    }

    /**
     * Method to set the value of field payment_whatsapp_success_error
     *
     * @param string $payment_whatsapp_success_error
     * @return $this
     */
    public function setPaymentWhatsappSuccessError($payment_whatsapp_success_error)
    {
        $this->payment_whatsapp_success_error = $payment_whatsapp_success_error;

        return $this;
    }

    /**
     * Method to set the value of field payment_whatsapp_success_date
     *
     * @param integer $payment_whatsapp_success_date
     * @return $this
     */
    public function setPaymentWhatsappSuccessDate($payment_whatsapp_success_date)
    {
        $this->payment_whatsapp_success_date = $payment_whatsapp_success_date;

        return $this;
    }

    /**
     * Returns the value of field payment_id
     *
     * @return integer
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * Returns the value of field payment_user_id
     *
     * @return integer
     */
    public function getPaymentUserId()
    {
        return $this->payment_user_id;
    }

    /**
     * Returns the value of field payment_amount
     *
     * @return double
     */
    public function getPaymentAmount()
    {
        return $this->payment_amount;
    }

    /**
     * Returns the value of field payment_for
     *
     * @return string
     */
    public function getPaymentFor()
    {
        return $this->payment_for;
    }

    /**
     * Returns the value of field payment_note
     *
     * @return string
     */
    public function getPaymentNote()
    {
        return $this->payment_note;
    }

    /**
     * Returns the value of field payment_method
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * Returns the value of field payment_cardtype
     *
     * @return string
     */
    public function getPaymentCardtype()
    {
        return $this->payment_cardtype;
    }

    /**
     * Returns the value of field payment_isenrolled3d
     *
     * @return string
     */
    public function getPaymentIsenrolled3d()
    {
        return $this->payment_isenrolled3d;
    }

    /**
     * Returns the value of field payment_ispassed3d
     *
     * @return string
     */
    public function getPaymentIspassed3d()
    {
        return $this->payment_ispassed3d;
    }

    /**
     * Returns the value of field payment_insertdate
     *
     * @return integer
     */
    public function getPaymentInsertdate()
    {
        return $this->payment_insertdate;
    }

    /**
     * Returns the value of field payment_date
     *
     * @return integer
     */
    public function getPaymentDate()
    {
        return $this->payment_date;
    }

    /**
     * Returns the value of field payment_status
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->payment_status;
    }

    /**
     * Returns the value of field payment_transation_id
     *
     * @return string
     */
    public function getPaymentTransationId()
    {
        return $this->payment_transation_id;
    }

    /**
     * Returns the value of field payment_transation_date
     *
     * @return string
     */
    public function getPaymentTransationDate()
    {
        return $this->payment_transation_date;
    }

    /**
     * Returns the value of field payment_creditcard
     *
     * @return string
     */
    public function getPaymentCreditcard()
    {
        return $this->payment_creditcard;
    }

    /**
     * Returns the value of field payment_creditname
     *
     * @return string
     */
    public function getPaymentCreditname()
    {
        return $this->payment_creditname;
    }

    /**
     * Returns the value of field payment_fail_reason
     *
     * @return string
     */
    public function getPaymentFailReason()
    {
        return $this->payment_fail_reason;
    }

    /**
     * Returns the value of field payment_currency
     *
     * @return string
     */
    public function getPaymentCurrency()
    {
        return $this->payment_currency;
    }

    /**
     * Returns the value of field payment_exrate
     *
     * @return double
     */
    public function getPaymentExrate()
    {
        return $this->payment_exrate;
    }

    /**
     * Returns the value of field payment_exrate_date
     *
     * @return integer
     */
    public function getPaymentExrateDate()
    {
        return $this->payment_exrate_date;
    }

    /**
     * Returns the value of field payment_user_local_id
     *
     * @return integer
     */
    public function getPaymentUserLocalId()
    {
        return $this->payment_user_local_id;
    }

    /**
     * Returns the value of field payment_user_service_id
     *
     * @return integer
     */
    public function getPaymentUserServiceId()
    {
        return $this->payment_user_service_id;
    }

    /**
     * Returns the value of field payment_whatsapp_success_id
     *
     * @return string
     */
    public function getPaymentWhatsappSuccessId()
    {
        return $this->payment_whatsapp_success_id;
    }

    /**
     * Returns the value of field payment_whatsapp_success_status
     *
     * @return string
     */
    public function getPaymentWhatsappSuccessStatus()
    {
        return $this->payment_whatsapp_success_status;
    }

    /**
     * Returns the value of field payment_whatsapp_success_error
     *
     * @return string
     */
    public function getPaymentWhatsappSuccessError()
    {
        return $this->payment_whatsapp_success_error;
    }

    /**
     * Returns the value of field payment_whatsapp_success_date
     *
     * @return integer
     */
    public function getPaymentWhatsappSuccessDate()
    {
        return $this->payment_whatsapp_success_date;
    }

    /**
     * Initialize method for model.
     */
//    public function initialize()
//    {
//        $this->setSchema("indianimmigrationorgnew");
//        $this->setSource("visa_payment");
//    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_payment';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPayment[]|VisaPayment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPayment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getFormattedId()
    {
        $di = Di::getDefault();
        $my = $di->get('my');
        return $my->formatPaymentID($this->getPaymentInsertdate(), $this->getPaymentId());
    }

    public function getInvoiceFileName()
    {
        $di = Di::getDefault();
        $my = $di->get('my');
        return $my->getPdfInvoicePaymentName($this->getFormattedId(), $this->getPaymentInsertdate());
    }

    public function getInvoiceFile()
    {
        $date = $this->getPaymentInsertdate();
        $year = date("Y", $date);
        $month = date("m", $date);
        $invoice_file = 'pdf/uploads' . (defined('TEST_MODE') && TEST_MODE ? '_test' : '') . '/makepayment/' . $year . '/' . $month . '/' . $this->getInvoiceFileName();
        return $invoice_file;
    }

    public function getReceiptFileName()
    {
        $di = Di::getDefault();
        $my = $di->get('my');
        return $my->getPdfReceiptPaymentName($this->getFormattedId(), $this->getPaymentInsertdate());
    }

    public function getReceiptFile()
    {
        $date = $this->getPaymentInsertdate();
        $year = date("Y", $date);
        $month = date("m", $date);
        $invoice_file = 'pdf/uploads' . (defined('TEST_MODE') && TEST_MODE ? '_test' : '') . '/makepayment/' . $year . '/' . $month . '/' . $this->getReceiptFileName();
        return $invoice_file;
    }
}
