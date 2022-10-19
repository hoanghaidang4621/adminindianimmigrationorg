<?php

namespace Visacorp\Models;



class UserCorp extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=20, nullable=false)
     */
    protected $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_password;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_tel;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_country_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_address;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_skype;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_convience;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_role;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $user_insert_time;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $user_active;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $user_payment_fails;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_avatar;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $user_type;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $user_success_order;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $user_token;


    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_url_facebook;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_number;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_local_format;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_international_format;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_country_prefix;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_country_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_country_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_location;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_carrier;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_telapi_line_type;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $user_unsubscribe_token;


     /**
     * Method to set the value of field user_id
     *
     * @param integer $user_id
     * @return $this
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Method to set the value of field user_name
     *
     * @param string $user_name
     * @return $this
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * Method to set the value of field user_email
     *
     * @param string $user_email
     * @return $this
     */
    public function setUserEmail($user_email)
    {
        $this->user_email = $user_email;

        return $this;
    }

    /**
     * Method to set the value of field user_password
     *
     * @param string $user_password
     * @return $this
     */
    public function setUserPassword($user_password)
    {
        $this->user_password = $user_password;

        return $this;
    }

    /**
     * Method to set the value of field user_tel
     *
     * @param string $user_tel
     * @return $this
     */
    public function setUserTel($user_tel)
    {
        $this->user_tel = $user_tel;

        return $this;
    }

    /**
     * Method to set the value of field user_country_id
     *
     * @param string $user_country_id
     * @return $this
     */
    public function setUserCountryId($user_country_id)
    {
        $this->user_country_id = $user_country_id;

        return $this;
    }

    /**
     * Method to set the value of field user_address
     *
     * @param string $user_address
     * @return $this
     */
    public function setUserAddress($user_address)
    {
        $this->user_address = $user_address;

        return $this;
    }

    /**
     * Method to set the value of field user_skype
     *
     * @param string $user_skype
     * @return $this
     */
    public function setUserSkype($user_skype)
    {
        $this->user_skype = $user_skype;

        return $this;
    }

    /**
     * Method to set the value of field user_convience
     *
     * @param string $user_convience
     * @return $this
     */
    public function setUserConvience($user_convience)
    {
        $this->user_convience = $user_convience;

        return $this;
    }

    /**
     * Method to set the value of field user_role
     *
     * @param string $user_role
     * @return $this
     */
    public function setUserRole($user_role)
    {
        $this->user_role = $user_role;

        return $this;
    }

    /**
     * Method to set the value of field user_insert_time
     *
     * @param integer $user_insert_time
     * @return $this
     */
    public function setUserInsertTime($user_insert_time)
    {
        $this->user_insert_time = $user_insert_time;

        return $this;
    }

    /**
     * Method to set the value of field user_active
     *
     * @param string $user_active
     * @return $this
     */
    public function setUserActive($user_active)
    {
        $this->user_active = $user_active;

        return $this;
    }

    /**
     * Method to set the value of field user_payment_fails
     *
     * @param integer $user_payment_fails
     * @return $this
     */
    public function setUserPaymentFails($user_payment_fails)
    {
        $this->user_payment_fails = $user_payment_fails;

        return $this;
    }

    /**
     * Method to set the value of field user_avatar
     *
     * @param string $user_avatar
     * @return $this
     */
    public function setUserAvatar($user_avatar)
    {
        $this->user_avatar = $user_avatar;

        return $this;
    }

    /**
     * Method to set the value of field user_type
     *
     * @param integer $user_type
     * @return $this
     */
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;

        return $this;
    }

    /**
     * Method to set the value of field user_success_order
     *
     * @param integer $user_success_order
     * @return $this
     */
    public function setUserSuccessOrder($user_success_order)
    {
        $this->user_success_order = $user_success_order;

        return $this;
    }

    /**
     * Method to set the value of field user_token
     *
     * @param string $user_token
     * @return $this
     */
    public function setUserToken($user_token)
    {
        $this->user_token = $user_token;

        return $this;
    }

    /**
     * Method to set the value of field user_url_facebook
     *
     * @param string $user_url_facebook
     * @return $this
     */
    public function setUserUrlFacebook($user_url_facebook)
    {
        $this->user_url_facebook = $user_url_facebook;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_number
     *
     * @param string $user_telapi_number
     * @return $this
     */
    public function setUserTelapiNumber($user_telapi_number)
    {
        $this->user_telapi_number = $user_telapi_number;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_local_format
     *
     * @param string $user_telapi_local_format
     * @return $this
     */
    public function setUserTelapiLocalFormat($user_telapi_local_format)
    {
        $this->user_telapi_local_format = $user_telapi_local_format;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_international_format
     *
     * @param string $user_telapi_international_format
     * @return $this
     */
    public function setUserTelapiInternationalFormat($user_telapi_international_format)
    {
        $this->user_telapi_international_format = $user_telapi_international_format;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_country_prefix
     *
     * @param string $user_telapi_country_prefix
     * @return $this
     */
    public function setUserTelapiCountryPrefix($user_telapi_country_prefix)
    {
        $this->user_telapi_country_prefix = $user_telapi_country_prefix;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_country_code
     *
     * @param string $user_telapi_country_code
     * @return $this
     */
    public function setUserTelapiCountryCode($user_telapi_country_code)
    {
        $this->user_telapi_country_code = $user_telapi_country_code;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_country_name
     *
     * @param string $user_telapi_country_name
     * @return $this
     */
    public function setUserTelapiCountryName($user_telapi_country_name)
    {
        $this->user_telapi_country_name = $user_telapi_country_name;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_location
     *
     * @param string $user_telapi_location
     * @return $this
     */
    public function setUserTelapiLocation($user_telapi_location)
    {
        $this->user_telapi_location = $user_telapi_location;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_carrier
     *
     * @param string $user_telapi_carrier
     * @return $this
     */
    public function setUserTelapiCarrier($user_telapi_carrier)
    {
        $this->user_telapi_carrier = $user_telapi_carrier;

        return $this;
    }

    /**
     * Method to set the value of field user_telapi_line_type
     *
     * @param string $user_telapi_line_type
     * @return $this
     */
    public function setUserTelapiLineType($user_telapi_line_type)
    {
        $this->user_telapi_line_type = $user_telapi_line_type;

        return $this;
    }

    /**
     * Method to set the value of field user_unsubscribe_token
     *
     * @param string $user_unsubscribe_token
     * @return $this
     */
    public function setUserUnSubscribeToken($user_unsubscribe_token)
    {
        $this->user_unsubscribe_token = $user_unsubscribe_token;

        return $this;
    }

    /**
     * Returns the value of field user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Returns the value of field user_name
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Returns the value of field user_email
     *
     * @return string
     */
    public function getUserEmail()
    {
        return $this->user_email;
    }

    /**
     * Returns the value of field user_password
     *
     * @return string
     */
    public function getUserPassword()
    {
        return $this->user_password;
    }

    /**
     * Returns the value of field user_tel
     *
     * @return string
     */
    public function getUserTel()
    {
        return $this->user_tel;
    }

    /**
     * Returns the value of field user_country_id
     *
     * @return string
     */
    public function getUserCountryId()
    {
        return $this->user_country_id;
    }

    /**
     * Returns the value of field user_address
     *
     * @return string
     */
    public function getUserAddress()
    {
        return $this->user_address;
    }

    /**
     * Returns the value of field user_skype
     *
     * @return string
     */
    public function getUserSkype()
    {
        return $this->user_skype;
    }

    /**
     * Returns the value of field user_convience
     *
     * @return string
     */
    public function getUserConvience()
    {
        return $this->user_convience;
    }

    /**
     * Returns the value of field user_role
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->user_role;
    }

    /**
     * Returns the value of field user_insert_time
     *
     * @return integer
     */
    public function getUserInsertTime()
    {
        return $this->user_insert_time;
    }

    /**
     * Returns the value of field user_active
     *
     * @return string
     */
    public function getUserActive()
    {
        return $this->user_active;
    }

    /**
     * Returns the value of field user_payment_fails
     *
     * @return integer
     */
    public function getUserPaymentFails()
    {
        return $this->user_payment_fails;
    }

    /**
     * Returns the value of field user_avatar
     *
     * @return string
     */
    public function getUserAvatar()
    {
        return $this->user_avatar;
    }

    /**
     * Returns the value of field user_type
     *
     * @return integer
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * Returns the value of field user_success_order
     *
     * @return integer
     */
    public function getUserSuccessOrder()
    {
        return $this->user_success_order;
    }

    /**
     * Returns the value of field user_token
     *
     * @return string
     */
    public function getUserToken()
    {
        return $this->user_token;
    }

    /**
     * Returns the value of field user_url_facebook
     *
     * @return string
     */
    public function getUserUrlFacebook()
    {
        return $this->user_url_facebook;
    }

    /**
     * Returns the value of field user_telapi_number
     *
     * @return string
     */
    public function getUserTelapiNumber()
    {
        return $this->user_telapi_number;
    }

    /**
     * Returns the value of field user_telapi_local_format
     *
     * @return string
     */
    public function getUserTelapiLocalFormat()
    {
        return $this->user_telapi_local_format;
    }

    /**
     * Returns the value of field user_telapi_international_format
     *
     * @return string
     */
    public function getUserTelapiInternationalFormat()
    {
        return $this->user_telapi_international_format;
    }

    /**
     * Returns the value of field user_telapi_country_prefix
     *
     * @return string
     */
    public function getUserTelapiCountryPrefix()
    {
        return $this->user_telapi_country_prefix;
    }

    /**
     * Returns the value of field user_telapi_country_code
     *
     * @return string
     */
    public function getUserTelapiCountryCode()
    {
        return $this->user_telapi_country_code;
    }

    /**
     * Returns the value of field user_telapi_country_name
     *
     * @return string
     */
    public function getUserTelapiCountryName()
    {
        return $this->user_telapi_country_name;
    }

    /**
     * Returns the value of field user_telapi_location
     *
     * @return string
     */
    public function getUserTelapiLocation()
    {
        return $this->user_telapi_location;
    }

    /**
     * Returns the value of field user_telapi_carrier
     *
     * @return string
     */
    public function getUserTelapiCarrier()
    {
        return $this->user_telapi_carrier;
    }

    /**
     * Returns the value of field user_telapi_line_type
     *
     * @return string
     */
    public function getUserTelapiLineType()
    {
        return $this->user_telapi_line_type;
    }

    /**
     * Returns the value of field user_unsubscribe_token
     *
     * @return string
     */
    public function getUserUnSubscribeToken()
    {
        return $this->user_unsubscribe_token;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setConnectionService('db_visacorp');
        $config = $this->getDI()->get('db_visacorp')->getDescriptor();
        $this->setSchema($config['schema']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserCorp[]|UserCorp
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserCorp
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
