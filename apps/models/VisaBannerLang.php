<?php
namespace Indianimmigrationorg\Models;
class VisaBannerLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $banner_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    public $banner_lang_code;

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
     * Method to set the value of field banner_lang_code
     *
     * @param string $banner_lang_code
     * @return $this
     */
    public function setBannerLangCode($banner_lang_code)
    {
        $this->banner_lang_code = $banner_lang_code;

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
     * Returns the value of field banner_id
     *
     * @return integer
     */
    public function getBannerId()
    {
        return $this->banner_id;
    }

    /**
     * Returns the value of field banner_lang_code
     *
     * @return string
     */
    public function getBannerLangCode()
    {
        return $this->banner_lang_code;
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
        return 'visa_banner_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaBannerLang[]|VisaBannerLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaBannerLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $banner_id
     * @return VisaBannerLang[]|VisaBannerLang
     */
    public static function findById($banner_id)
    {
        return self::find(array(
            "banner_id =:ID:",
            'bind' => array('ID' => $banner_id)
        ));
    }
}
