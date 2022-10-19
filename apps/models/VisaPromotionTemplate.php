<?php

namespace Indianimmigrationorg\Models;

class VisaPromotionTemplate extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $template_id;

    /**
     *
     * @var string
     * @Column(type="string", length=256, nullable=false)
     */
    protected $template_title;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $template_content;

    /**
     *
     * @var string
     * @Column(type="string", length=256, nullable=false)
     */
    protected $template_test_email;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $template_create_date;

    /**
     * Method to set the value of field template_id
     *
     * @param integer $template_id
     * @return $this
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;

        return $this;
    }

    /**
     * Method to set the value of field template_title
     *
     * @param string $template_title
     * @return $this
     */
    public function setTemplateTitle($template_title)
    {
        $this->template_title = $template_title;

        return $this;
    }

    /**
     * Method to set the value of field template_content
     *
     * @param string $template_content
     * @return $this
     */
    public function setTemplateContent($template_content)
    {
        $this->template_content = $template_content;

        return $this;
    }

    /**
     * Method to set the value of field template_test_email
     *
     * @param string $template_test_email
     * @return $this
     */
    public function setTemplateTestEmail($template_test_email)
    {
        $this->template_test_email = $template_test_email;

        return $this;
    }

    /**
     * Method to set the value of field template_create_date
     *
     * @param integer $template_create_date
     * @return $this
     */
    public function setTemplateCreateDate($template_create_date)
    {
        $this->template_create_date = $template_create_date;

        return $this;
    }

    /**
     * Returns the value of field template_id
     *
     * @return integer
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * Returns the value of field template_title
     *
     * @return string
     */
    public function getTemplateTitle()
    {
        return $this->template_title;
    }

    /**
     * Returns the value of field template_content
     *
     * @return string
     */
    public function getTemplateContent()
    {
        return $this->template_content;
    }

    /**
     * Returns the value of field template_test_email
     *
     * @return string
     */
    public function getTemplateTestEmail()
    {
        return $this->template_test_email;
    }

    /**
     * Returns the value of field template_create_date
     *
     * @return integer
     */
    public function getTemplateCreateDate()
    {
        return $this->template_create_date;
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
        return 'visa_promotion_template';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotionTemplate[]|VisaPromotionTemplate
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotionTemplate
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
