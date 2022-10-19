<?php

namespace Indianimmigrationorg\Models;

class VisaPromotionTemplateLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $template_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $template_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $template_title;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $template_content;

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
     * Method to set the value of field template_lang_code
     *
     * @param string $template_lang_code
     * @return $this
     */
    public function setTemplateLangCode($template_lang_code)
    {
        $this->template_lang_code = $template_lang_code;

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
     * Returns the value of field template_id
     *
     * @return integer
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * Returns the value of field template_lang_code
     *
     * @return string
     */
    public function getTemplateLangCode()
    {
        return $this->template_lang_code;
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
        return 'visa_promotion_template_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotionTemplateLang[]|VisaPromotionTemplateLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPromotionTemplateLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
