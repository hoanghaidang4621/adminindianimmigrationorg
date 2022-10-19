<?php

namespace Indianimmigrationorg\Models;

class VisaArticleLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", nullable=false)
     */
    protected $article_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $article_lang_code;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $article_location_country_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $article_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $article_name_footer;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $article_name_home;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $article_title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $article_keyword;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $article_meta_keyword;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $article_meta_description;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $article_meta_image;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $article_summary;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $article_content;

    /**
     * Method to set the value of field article_id
     *
     * @param integer $article_id
     * @return $this
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;

        return $this;
    }

    /**
     * Method to set the value of field article_lang_code
     *
     * @param string $article_lang_code
     * @return $this
     */
    public function setArticleLangCode($article_lang_code)
    {
        $this->article_lang_code = $article_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field article_location_country_code
     *
     * @param string $article_location_country_code
     * @return $this
     */
    public function setArticleLocationCountryCode($article_location_country_code)
    {
        $this->article_location_country_code = $article_location_country_code;

        return $this;
    }

    /**
     * Method to set the value of field article_name
     *
     * @param string $article_name
     * @return $this
     */
    public function setArticleName($article_name)
    {
        $this->article_name = $article_name;

        return $this;
    }

    /**
     * Method to set the value of field article_name_footer
     *
     * @param string $article_name_footer
     * @return $this
     */
    public function setArticleNameFooter($article_name_footer)
    {
        $this->article_name_footer = $article_name_footer;

        return $this;
    }

    /**
     * Method to set the value of field article_name_home
     *
     * @param string $article_name_home
     * @return $this
     */
    public function setArticleNameHome($article_name_home)
    {
        $this->article_name_home = $article_name_home;

        return $this;
    }

    /**
     * Method to set the value of field article_title
     *
     * @param string $article_title
     * @return $this
     */
    public function setArticleTitle($article_title)
    {
        $this->article_title = $article_title;

        return $this;
    }

    /**
     * Method to set the value of field article_keyword
     *
     * @param string $article_keyword
     * @return $this
     */
    public function setArticleKeyword($article_keyword)
    {
        $this->article_keyword = $article_keyword;

        return $this;
    }

    /**
     * Method to set the value of field article_meta_keyword
     *
     * @param string $article_meta_keyword
     * @return $this
     */
    public function setArticleMetaKeyword($article_meta_keyword)
    {
        $this->article_meta_keyword = $article_meta_keyword;

        return $this;
    }

    /**
     * Method to set the value of field article_meta_description
     *
     * @param string $article_meta_description
     * @return $this
     */
    public function setArticleMetaDescription($article_meta_description)
    {
        $this->article_meta_description = $article_meta_description;

        return $this;
    }

    /**
     * Method to set the value of field article_meta_image
     *
     * @param string $article_meta_image
     * @return $this
     */
    public function setArticleMetaImage($article_meta_image)
    {
        $this->article_meta_image = $article_meta_image;

        return $this;
    }

    /**
     * Method to set the value of field article_summary
     *
     * @param string $article_summary
     * @return $this
     */
    public function setArticleSummary($article_summary)
    {
        $this->article_summary = $article_summary;

        return $this;
    }

    /**
     * Method to set the value of field article_content
     *
     * @param string $article_content
     * @return $this
     */
    public function setArticleContent($article_content)
    {
        $this->article_content = $article_content;

        return $this;
    }

    /**
     * Returns the value of field article_id
     *
     * @return integer
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * Returns the value of field article_lang_code
     *
     * @return string
     */
    public function getArticleLangCode()
    {
        return $this->article_lang_code;
    }

    /**
     * Returns the value of field article_location_country_code
     *
     * @return string
     */
    public function getArticleLocationCountryCode()
    {
        return $this->article_location_country_code;
    }

    /**
     * Returns the value of field article_name
     *
     * @return string
     */
    public function getArticleName()
    {
        return $this->article_name;
    }

    /**
     * Returns the value of field article_name_footer
     *
     * @return string
     */
    public function getArticleNameFooter()
    {
        return $this->article_name_footer;
    }

    /**
     * Returns the value of field article_name_home
     *
     * @return string
     */
    public function getArticleNameHome()
    {
        return $this->article_name_home;
    }

    /**
     * Returns the value of field article_title
     *
     * @return string
     */
    public function getArticleTitle()
    {
        return $this->article_title;
    }

    /**
     * Returns the value of field article_keyword
     *
     * @return string
     */
    public function getArticleKeyword()
    {
        return $this->article_keyword;
    }

    /**
     * Returns the value of field article_meta_keyword
     *
     * @return string
     */
    public function getArticleMetaKeyword()
    {
        return $this->article_meta_keyword;
    }

    /**
     * Returns the value of field article_meta_description
     *
     * @return string
     */
    public function getArticleMetaDescription()
    {
        return $this->article_meta_description;
    }

    /**
     * Returns the value of field article_meta_image
     *
     * @return string
     */
    public function getArticleMetaImage()
    {
        return $this->article_meta_image;
    }

    /**
     * Returns the value of field article_summary
     *
     * @return string
     */
    public function getArticleSummary()
    {
        return $this->article_summary;
    }

    /**
     * Returns the value of field article_content
     *
     * @return string
     */
    public function getArticleContent()
    {
        return $this->article_content;
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
        return 'visa_article_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaArticleLang[]|VisaArticleLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaArticleLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
