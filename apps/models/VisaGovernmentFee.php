<?php

namespace Indianimmigrationorg\Models;

class VisaGovernmentFee extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $fee_visatype_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $fee_country_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $fee_value;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $fee_note;

    /**
     * Method to set the value of field fee_visatype_id
     *
     * @param integer $fee_visatype_id
     * @return $this
     */
    public function setFeeVisatypeId($fee_visatype_id)
    {
        $this->fee_visatype_id = $fee_visatype_id;

        return $this;
    }

    /**
     * Method to set the value of field fee_country_id
     *
     * @param integer $fee_country_id
     * @return $this
     */
    public function setFeeCountryId($fee_country_id)
    {
        $this->fee_country_id = $fee_country_id;

        return $this;
    }

    /**
     * Method to set the value of field fee_value
     *
     * @param double $fee_value
     * @return $this
     */
    public function setFeeValue($fee_value)
    {
        $this->fee_value = $fee_value;

        return $this;
    }

    /**
     * Method to set the value of field fee_note
     *
     * @param string $fee_note
     * @return $this
     */
    public function setFeeNote($fee_note)
    {
        $this->fee_note = $fee_note;

        return $this;
    }

    /**
     * Returns the value of field fee_visatype_id
     *
     * @return integer
     */
    public function getFeeVisatypeId()
    {
        return $this->fee_visatype_id;
    }

    /**
     * Returns the value of field fee_country_id
     *
     * @return integer
     */
    public function getFeeCountryId()
    {
        return $this->fee_country_id;
    }

    /**
     * Returns the value of field fee_value
     *
     * @return double
     */
    public function getFeeValue()
    {
        return $this->fee_value;
    }

    /**
     * Returns the value of field fee_note
     *
     * @return string
     */
    public function getFeeNote()
    {
        return $this->fee_note;
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
        return 'visa_government_fee';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGovernmentFee[]|VisaGovernmentFee
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaGovernmentFee
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
