<?php

namespace Indianimmigrationorg\Models;

class VisaPromotion extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $promotion_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $promotion_code;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $promotion_startdate;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $promotion_enddate;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $promotion_percent;

    /**
     * Method to set the value of field promotion_id
     *
     * @param integer $promotion_id
     * @return $this
     */
    public function setPromotionId($promotion_id)
    {
        $this->promotion_id = $promotion_id;

        return $this;
    }

    /**
     * Method to set the value of field promotion_code
     *
     * @param string $promotion_code
     * @return $this
     */
    public function setPromotionCode($promotion_code)
    {
        $this->promotion_code = $promotion_code;

        return $this;
    }

    /**
     * Method to set the value of field promotion_startdate
     *
     * @param integer $promotion_startdate
     * @return $this
     */
    public function setPromotionStartdate($promotion_startdate)
    {
        $this->promotion_startdate = $promotion_startdate;

        return $this;
    }

    /**
     * Method to set the value of field promotion_enddate
     *
     * @param integer $promotion_enddate
     * @return $this
     */
    public function setPromotionEnddate($promotion_enddate)
    {
        $this->promotion_enddate = $promotion_enddate;

        return $this;
    }

    /**
     * Method to set the value of field promotion_percent
     *
     * @param double $promotion_percent
     * @return $this
     */
    public function setPromotionPercent($promotion_percent)
    {
        $this->promotion_percent = $promotion_percent;

        return $this;
    }

    /**
     * Returns the value of field promotion_id
     *
     * @return integer
     */
    public function getPromotionId()
    {
        return $this->promotion_id;
    }

    /**
     * Returns the value of field promotion_code
     *
     * @return string
     */
    public function getPromotionCode()
    {
        return $this->promotion_code;
    }

    /**
     * Returns the value of field promotion_startdate
     *
     * @return integer
     */
    public function getPromotionStartdate()
    {
        return $this->promotion_startdate;
    }

    /**
     * Returns the value of field promotion_enddate
     *
     * @return integer
     */
    public function getPromotionEnddate()
    {
        return $this->promotion_enddate;
    }

    /**
     * Returns the value of field promotion_percent
     *
     * @return double
     */
    public function getPromotionPercent()
    {
        return $this->promotion_percent;
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
        return 'visa_promotion';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotion[]|VisaPromotion
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotion
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
