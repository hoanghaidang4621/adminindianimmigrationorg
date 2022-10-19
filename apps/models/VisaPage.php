<?php
namespace Indianimmigrationorg\Models;
class VisaPage extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $page_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    public $page_location_country_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_keyword;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_meta_keyword;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_meta_description;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $page_meta_image;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $page_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $page_active;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $page_is_landing_page;

    /**
     * Method to set the value of field page_id
     *
     * @param integer $page_id
     * @return $this
     */
    public function setPageId($page_id)
    {
        $this->page_id = $page_id;

        return $this;
    }

    /**
     * Method to set the value of field page_location_country_code
     *
     * @param string $page_location_country_code
     * @return $this
     */
    public function setPageLocationCountryCode($page_location_country_code)
    {
        $this->page_location_country_code = $page_location_country_code;

        return $this;
    }

    /**
     * Method to set the value of field page_name
     *
     * @param string $page_name
     * @return $this
     */
    public function setPageName($page_name)
    {
        $this->page_name = $page_name;

        return $this;
    }

    /**
     * Method to set the value of field page_title
     *
     * @param string $page_title
     * @return $this
     */
    public function setPageTitle($page_title)
    {
        $this->page_title = $page_title;

        return $this;
    }

    /**
     * Method to set the value of field page_keyword
     *
     * @param string $page_keyword
     * @return $this
     */
    public function setPageKeyword($page_keyword)
    {
        $this->page_keyword = $page_keyword;

        return $this;
    }

    /**
     * Method to set the value of field page_meta_keyword
     *
     * @param string $page_meta_keyword
     * @return $this
     */
    public function setPageMetaKeyword($page_meta_keyword)
    {
        $this->page_meta_keyword = $page_meta_keyword;

        return $this;
    }

    /**
     * Method to set the value of field page_meta_description
     *
     * @param string $page_meta_description
     * @return $this
     */
    public function setPageMetaDescription($page_meta_description)
    {
        $this->page_meta_description = $page_meta_description;

        return $this;
    }

    /**
     * Method to set the value of field page_meta_image
     *
     * @param string $page_meta_image
     * @return $this
     */
    public function setPageMetaImage($page_meta_image)
    {
        $this->page_meta_image = $page_meta_image;

        return $this;
    }

    /**
     * Method to set the value of field page_content
     *
     * @param string $page_content
     * @return $this
     */
    public function setPageContent($page_content)
    {
        $this->page_content = $page_content;

        return $this;
    }



    /**
     * Method to set the value of field page_active
     *
     * @param string $page_active
     * @return $this
     */
    public function setPageActive($page_active)
    {
        $this->page_active = $page_active;

        return $this;
    }

    /**
     * Method to set the value of field page_is_landing_page
     *
     * @param string $page_is_landing_page
     * @return $this
     */
    public function setPageIsLandingPage($page_is_landing_page)
    {
        $this->page_is_landing_page = $page_is_landing_page;

        return $this;
    }

    /**
     * Returns the value of field page_id
     *
     * @return integer
     */
    public function getPageId()
    {
        return $this->page_id;
    }

    /**
     * Returns the value of field page_location_country_code
     *
     * @return string
     */
    public function getPageLocationCountryCode()
    {
        return $this->page_location_country_code;
    }

    /**
     * Returns the value of field page_name
     *
     * @return string
     */
    public function getPageName()
    {
        return $this->page_name;
    }

    /**
     * Returns the value of field page_title
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->page_title;
    }

    /**
     * Returns the value of field page_keyword
     *
     * @return string
     */
    public function getPageKeyword()
    {
        return $this->page_keyword;
    }

    /**
     * Returns the value of field page_meta_keyword
     *
     * @return string
     */
    public function getPageMetaKeyword()
    {
        return $this->page_meta_keyword;
    }

    /**
     * Returns the value of field page_meta_description
     *
     * @return string
     */
    public function getPageMetaDescription()
    {
        return $this->page_meta_description;
    }

    /**
     * Returns the value of field page_meta_image
     *
     * @return string
     */
    public function getPageMetaImage()
    {
        return $this->page_meta_image;
    }

    /**
     * Returns the value of field page_content
     *
     * @return string
     */
    public function getPageContent()
    {
        return $this->page_content;
    }

    /**
     * Returns the value of field page_active
     *
     * @return string
     */
    public function getPageActive()
    {
        return $this->page_active;
    }

    /**
     * Returns the value of field page_is_landing_page
     *
     * @return string
     */
    public function getPageIsLandingPage()
    {
        return $this->page_is_landing_page;
    }

    /**
     * Initialize method for model.
     */
    /*public function initialize()
    {
        $this->setSchema("admin_visa_com");
    }*/

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'visa_page';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPage[]|VisaPage
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaPage
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
