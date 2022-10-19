<?php

namespace Indianimmigrationorg\Models;

class VisaProcessingFeeLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $processing_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $processing_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $processing_name;

    /**
     * Method to set the value of field processing_id
     *
     * @param integer $processing_id
     * @return $this
     */
    public function setProcessingId($processing_id)
    {
        $this->processing_id = $processing_id;

        return $this;
    }

    /**
     * Method to set the value of field processing_lang_code
     *
     * @param string $processing_lang_code
     * @return $this
     */
    public function setProcessingLangCode($processing_lang_code)
    {
        $this->processing_lang_code = $processing_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field processing_name
     *
     * @param string $processing_name
     * @return $this
     */
    public function setProcessingName($processing_name)
    {
        $this->processing_name = $processing_name;

        return $this;
    }

    /**
     * Returns the value of field processing_id
     *
     * @return integer
     */
    public function getProcessingId()
    {
        return $this->processing_id;
    }

    /**
     * Returns the value of field processing_lang_code
     *
     * @return string
     */
    public function getProcessingLangCode()
    {
        return $this->processing_lang_code;
    }

    /**
     * Returns the value of field processing_name
     *
     * @return string
     */
    public function getProcessingName()
    {
        return $this->processing_name;
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
        return 'visa_processing_fee_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaProcessingFeeLang[]|VisaProcessingFeeLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaProcessingFeeLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
