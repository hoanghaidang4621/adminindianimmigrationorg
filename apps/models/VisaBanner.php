<?php
namespace Indianimmigrationorg\Models;
class VisaBanner extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $banner_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $banner_controller;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $banner_article_keyword;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $banner_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $banner_content;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $banner_link;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $banner_image;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $banner_image_mobile;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $banner_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $banner_active;


    /**
     * Method to set the value of field banner_id
     *
     * @param integer $banner_id
     * @return $this
     */
    public function setBannerId($banner_id)
    {
        $this->banner_id = $banner_id;

        return $this;
    }

    /**
     * Method to set the value of field banner_controller
     *
     * @param string $banner_controller
     * @return $this
     */
    public function setBannerController($banner_controller)
    {
        $this->banner_controller = $banner_controller;

        return $this;
    }



    /**
     * Method to set the value of field banner_name
     *
     * @param string $banner_name
     * @return $this
     */
    public function setBannerName($banner_name)
    {
        $this->banner_name = $banner_name;

        return $this;
    }

    /**
     * Method to set the value of field banner_content
     *
     * @param string $banner_content
     * @return $this
     */
    public function setBannerContent($banner_content)
    {
        $this->banner_content = $banner_content;

        return $this;
    }

    /**
     * Method to set the value of field banner_link
     *
     * @param string $banner_link
     * @return $this
     */
    public function setBannerLink($banner_link)
    {
        $this->banner_link = $banner_link;

        return $this;
    }

    /**
     * Method to set the value of field banner_image
     *
     * @param string $banner_image
     * @return $this
     */
    public function setBannerImage($banner_image)
    {
        $this->banner_image = $banner_image;

        return $this;
    }

    /**
     * Method to set the value of field banner_article_keyword
     *
     * @param string $banner_article_keyword
     * @return $this
     */
    public function setBannerArticleKeyword($banner_article_keyword)
    {
        $this->banner_article_keyword = $banner_article_keyword;

        return $this;
    }

    /**
     * Method to set the value of field banner_image_mobile
     *
     * @param string $banner_image_mobile
     * @return $this
     */
    public function setBannerImageMobile($banner_image_mobile)
    {
        $this->banner_image_mobile = $banner_image_mobile;

        return $this;
    }

    /**
     * Method to set the value of field banner_order
     *
     * @param integer $banner_order
     * @return $this
     */
    public function setBannerOrder($banner_order)
    {
        $this->banner_order = $banner_order;

        return $this;
    }


    /**
     * Method to set the value of field banner_active
     *
     * @param string $banner_active
     * @return $this
     */
    public function setBannerActive($banner_active)
    {
        $this->banner_active = $banner_active;

        return $this;
    }

    /**
     * Returns the value of field banner_id
     *
     * @return integer
     */
    public function getBannerId()
    {
        return $this->banner_id;
    }

    /**
     * Returns the value of field banner_controller
     *
     * @return string
     */
    public function getBannerController()
    {
        return $this->banner_controller;
    }

    /**
     * Returns the value of field banner_locations
     *
     * @return string
     */
    public function getBannerLocations()
    {
        return $this->banner_locations;
    }


    /**
     * Returns the value of field banner_name
     *
     * @return string
     */
    public function getBannerName()
    {
        return $this->banner_name;
    }

    /**
     * Returns the value of field banner_content
     *
     * @return string
     */
    public function getBannerContent()
    {
        return $this->banner_content;
    }

    /**
     * Returns the value of field banner_link
     *
     * @return string
     */
    public function getBannerLink()
    {
        return $this->banner_link;
    }

    /**
     * Returns the value of field banner_image
     *
     * @return string
     */
    public function getBannerImage()
    {
        return $this->banner_image;
    }

    /**
     * Returns the value of field banner_image_mobile
     *
     * @return string
     */
    public function getBannerImageMobile()
    {
        return $this->banner_image_mobile;
    }

    /**
     * Returns the value of field banner_order
     *
     * @return integer
     */
    public function getBannerOrder()
    {
        return $this->banner_order;
    }


    /**
     * Returns the value of field banner_active
     *
     * @return string
     */
    public function getBannerActive()
    {
        return $this->banner_active;
    }

    /**
     * Returns the value of field banner_article_keyword
     *
     * @return string
     */
    public function getBannerArticleKeyword()
    {
        return $this->banner_article_keyword;
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
        return 'visa_banner';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaBanner[]|VisaBanner
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaBanner
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public static function findFirstById($id)
    {
        return self::findFirst(array(
            'banner_id = :id:',
            'bind' => array('id' => $id)
        ));
    }
}
