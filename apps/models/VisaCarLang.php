<?php

namespace Indianimmigrationorg\Models;

class VisaCarLang extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $car_id;

    /**
     *
     * @var string
     * @Primary
     * @Column(type="string", length=5, nullable=false)
     */
    protected $car_lang_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $car_name;

    /**
     * Method to set the value of field car_id
     *
     * @param integer $car_id
     * @return $this
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;

        return $this;
    }

    /**
     * Method to set the value of field car_lang_code
     *
     * @param string $car_lang_code
     * @return $this
     */
    public function setCarLangCode($car_lang_code)
    {
        $this->car_lang_code = $car_lang_code;

        return $this;
    }

    /**
     * Method to set the value of field car_name
     *
     * @param string $car_name
     * @return $this
     */
    public function setCarName($car_name)
    {
        $this->car_name = $car_name;

        return $this;
    }

    /**
     * Returns the value of field car_id
     *
     * @return integer
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * Returns the value of field car_lang_code
     *
     * @return string
     */
    public function getCarLangCode()
    {
        return $this->car_lang_code;
    }

    /**
     * Returns the value of field car_name
     *
     * @return string
     */
    public function getCarName()
    {
        return $this->car_name;
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
        return 'visa_car_lang';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCarLang[]|VisaCarLang
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaCarLang
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
