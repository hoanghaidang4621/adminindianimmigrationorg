<?php

namespace Indianimmigrationorg\Models;


class VisaOrderBin extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $bin_id;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $bin_order_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_code;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_bank;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_card;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_type;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_level;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_country;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_countrycode;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_website;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_phone;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_message;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_error;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_status;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_country;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_countrycode;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_region;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_regionname;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_city;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_zip;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_lat;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_lon;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_timezone;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_isp;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_org;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_as;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_reverse;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_query;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $bin_ip_message;

    /**
     * Method to set the value of field bin_id
     *
     * @param integer $bin_id
     * @return $this
     */
    public function setBinId($bin_id)
    {
        $this->bin_id = $bin_id;

        return $this;
    }

    /**
     * Method to set the value of field bin_order_id
     *
     * @param integer $bin_order_id
     * @return $this
     */
    public function setBinOrderId($bin_order_id)
    {
        $this->bin_order_id = $bin_order_id;

        return $this;
    }

    /**
     * Method to set the value of field bin_code
     *
     * @param string $bin_code
     * @return $this
     */
    public function setBinCode($bin_code)
    {
        $this->bin_code = $bin_code;

        return $this;
    }

    /**
     * Method to set the value of field bin_bank
     *
     * @param string $bin_bank
     * @return $this
     */
    public function setBinBank($bin_bank)
    {
        $this->bin_bank = $bin_bank;

        return $this;
    }

    /**
     * Method to set the value of field bin_card
     *
     * @param string $bin_card
     * @return $this
     */
    public function setBinCard($bin_card)
    {
        $this->bin_card = $bin_card;

        return $this;
    }

    /**
     * Method to set the value of field bin_type
     *
     * @param string $bin_type
     * @return $this
     */
    public function setBinType($bin_type)
    {
        $this->bin_type = $bin_type;

        return $this;
    }

    /**
     * Method to set the value of field bin_level
     *
     * @param string $bin_level
     * @return $this
     */
    public function setBinLevel($bin_level)
    {
        $this->bin_level = $bin_level;

        return $this;
    }

    /**
     * Method to set the value of field bin_country
     *
     * @param string $bin_country
     * @return $this
     */
    public function setBinCountry($bin_country)
    {
        $this->bin_country = $bin_country;

        return $this;
    }

    /**
     * Method to set the value of field bin_countrycode
     *
     * @param string $bin_countrycode
     * @return $this
     */
    public function setBinCountrycode($bin_countrycode)
    {
        $this->bin_countrycode = $bin_countrycode;

        return $this;
    }

    /**
     * Method to set the value of field bin_website
     *
     * @param string $bin_website
     * @return $this
     */
    public function setBinWebsite($bin_website)
    {
        $this->bin_website = $bin_website;

        return $this;
    }

    /**
     * Method to set the value of field bin_phone
     *
     * @param string $bin_phone
     * @return $this
     */
    public function setBinPhone($bin_phone)
    {
        $this->bin_phone = $bin_phone;

        return $this;
    }

    /**
     * Method to set the value of field bin_message
     *
     * @param string $bin_message
     * @return $this
     */
    public function setBinMessage($bin_message)
    {
        $this->bin_message = $bin_message;

        return $this;
    }

    /**
     * Method to set the value of field bin_error
     *
     * @param string $bin_error
     * @return $this
     */
    public function setBinError($bin_error)
    {
        $this->bin_error = $bin_error;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_status
     *
     * @param string $bin_ip_status
     * @return $this
     */
    public function setBinIpStatus($bin_ip_status)
    {
        $this->bin_ip_status = $bin_ip_status;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_country
     *
     * @param string $bin_ip_country
     * @return $this
     */
    public function setBinIpCountry($bin_ip_country)
    {
        $this->bin_ip_country = $bin_ip_country;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_countrycode
     *
     * @param string $bin_ip_countrycode
     * @return $this
     */
    public function setBinIpCountrycode($bin_ip_countrycode)
    {
        $this->bin_ip_countrycode = $bin_ip_countrycode;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_region
     *
     * @param string $bin_ip_region
     * @return $this
     */
    public function setBinIpRegion($bin_ip_region)
    {
        $this->bin_ip_region = $bin_ip_region;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_regionname
     *
     * @param string $bin_ip_regionname
     * @return $this
     */
    public function setBinIpRegionname($bin_ip_regionname)
    {
        $this->bin_ip_regionname = $bin_ip_regionname;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_city
     *
     * @param string $bin_ip_city
     * @return $this
     */
    public function setBinIpCity($bin_ip_city)
    {
        $this->bin_ip_city = $bin_ip_city;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_zip
     *
     * @param string $bin_ip_zip
     * @return $this
     */
    public function setBinIpZip($bin_ip_zip)
    {
        $this->bin_ip_zip = $bin_ip_zip;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_lat
     *
     * @param string $bin_ip_lat
     * @return $this
     */
    public function setBinIpLat($bin_ip_lat)
    {
        $this->bin_ip_lat = $bin_ip_lat;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_lon
     *
     * @param string $bin_ip_lon
     * @return $this
     */
    public function setBinIpLon($bin_ip_lon)
    {
        $this->bin_ip_lon = $bin_ip_lon;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_timezone
     *
     * @param string $bin_ip_timezone
     * @return $this
     */
    public function setBinIpTimezone($bin_ip_timezone)
    {
        $this->bin_ip_timezone = $bin_ip_timezone;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_isp
     *
     * @param string $bin_ip_isp
     * @return $this
     */
    public function setBinIpIsp($bin_ip_isp)
    {
        $this->bin_ip_isp = $bin_ip_isp;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_org
     *
     * @param string $bin_ip_org
     * @return $this
     */
    public function setBinIpOrg($bin_ip_org)
    {
        $this->bin_ip_org = $bin_ip_org;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_as
     *
     * @param string $bin_ip_as
     * @return $this
     */
    public function setBinIpAs($bin_ip_as)
    {
        $this->bin_ip_as = $bin_ip_as;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_reverse
     *
     * @param string $bin_ip_reverse
     * @return $this
     */
    public function setBinIpReverse($bin_ip_reverse)
    {
        $this->bin_ip_reverse = $bin_ip_reverse;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_query
     *
     * @param string $bin_ip_query
     * @return $this
     */
    public function setBinIpQuery($bin_ip_query)
    {
        $this->bin_ip_query = $bin_ip_query;

        return $this;
    }

    /**
     * Method to set the value of field bin_ip_message
     *
     * @param string $bin_ip_message
     * @return $this
     */
    public function setBinIpMessage($bin_ip_message)
    {
        $this->bin_ip_message = $bin_ip_message;

        return $this;
    }

    /**
     * Returns the value of field bin_id
     *
     * @return integer
     */
    public function getBinId()
    {
        return $this->bin_id;
    }

    /**
     * Returns the value of field bin_order_id
     *
     * @return integer
     */
    public function getBinOrderId()
    {
        return $this->bin_order_id;
    }

    /**
     * Returns the value of field bin_code
     *
     * @return string
     */
    public function getBinCode()
    {
        return $this->bin_code;
    }

    /**
     * Returns the value of field bin_bank
     *
     * @return string
     */
    public function getBinBank()
    {
        return $this->bin_bank;
    }

    /**
     * Returns the value of field bin_card
     *
     * @return string
     */
    public function getBinCard()
    {
        return $this->bin_card;
    }

    /**
     * Returns the value of field bin_type
     *
     * @return string
     */
    public function getBinType()
    {
        return $this->bin_type;
    }

    /**
     * Returns the value of field bin_level
     *
     * @return string
     */
    public function getBinLevel()
    {
        return $this->bin_level;
    }

    /**
     * Returns the value of field bin_country
     *
     * @return string
     */
    public function getBinCountry()
    {
        return $this->bin_country;
    }

    /**
     * Returns the value of field bin_countrycode
     *
     * @return string
     */
    public function getBinCountrycode()
    {
        return $this->bin_countrycode;
    }

    /**
     * Returns the value of field bin_website
     *
     * @return string
     */
    public function getBinWebsite()
    {
        return $this->bin_website;
    }

    /**
     * Returns the value of field bin_phone
     *
     * @return string
     */
    public function getBinPhone()
    {
        return $this->bin_phone;
    }

    /**
     * Returns the value of field bin_message
     *
     * @return string
     */
    public function getBinMessage()
    {
        return $this->bin_message;
    }

    /**
     * Returns the value of field bin_error
     *
     * @return string
     */
    public function getBinError()
    {
        return $this->bin_error;
    }

    /**
     * Returns the value of field bin_ip_status
     *
     * @return string
     */
    public function getBinIpStatus()
    {
        return $this->bin_ip_status;
    }

    /**
     * Returns the value of field bin_ip_country
     *
     * @return string
     */
    public function getBinIpCountry()
    {
        return $this->bin_ip_country;
    }

    /**
     * Returns the value of field bin_ip_countrycode
     *
     * @return string
     */
    public function getBinIpCountrycode()
    {
        return $this->bin_ip_countrycode;
    }

    /**
     * Returns the value of field bin_ip_region
     *
     * @return string
     */
    public function getBinIpRegion()
    {
        return $this->bin_ip_region;
    }

    /**
     * Returns the value of field bin_ip_regionname
     *
     * @return string
     */
    public function getBinIpRegionname()
    {
        return $this->bin_ip_regionname;
    }

    /**
     * Returns the value of field bin_ip_city
     *
     * @return string
     */
    public function getBinIpCity()
    {
        return $this->bin_ip_city;
    }

    /**
     * Returns the value of field bin_ip_zip
     *
     * @return string
     */
    public function getBinIpZip()
    {
        return $this->bin_ip_zip;
    }

    /**
     * Returns the value of field bin_ip_lat
     *
     * @return string
     */
    public function getBinIpLat()
    {
        return $this->bin_ip_lat;
    }

    /**
     * Returns the value of field bin_ip_lon
     *
     * @return string
     */
    public function getBinIpLon()
    {
        return $this->bin_ip_lon;
    }

    /**
     * Returns the value of field bin_ip_timezone
     *
     * @return string
     */
    public function getBinIpTimezone()
    {
        return $this->bin_ip_timezone;
    }

    /**
     * Returns the value of field bin_ip_isp
     *
     * @return string
     */
    public function getBinIpIsp()
    {
        return $this->bin_ip_isp;
    }

    /**
     * Returns the value of field bin_ip_org
     *
     * @return string
     */
    public function getBinIpOrg()
    {
        return $this->bin_ip_org;
    }

    /**
     * Returns the value of field bin_ip_as
     *
     * @return string
     */
    public function getBinIpAs()
    {
        return $this->bin_ip_as;
    }

    /**
     * Returns the value of field bin_ip_reverse
     *
     * @return string
     */
    public function getBinIpReverse()
    {
        return $this->bin_ip_reverse;
    }

    /**
     * Returns the value of field bin_ip_query
     *
     * @return string
     */
    public function getBinIpQuery()
    {
        return $this->bin_ip_query;
    }

    /**
     * Returns the value of field bin_ip_message
     *
     * @return string
     */
    public function getBinIpMessage()
    {
        return $this->bin_ip_message;
    }

//    /**
//     * Initialize method for model.
//     */
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
        return 'visa_order_bin';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderBin[]|VisaOrderBin
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderBin
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function setWithBinCodeInfo($binCodeInfo, $ipInfo)
    {
        if (isset($binCodeInfo)) {
            $binCodeDbKeys = BinCodes::getDbKeys();
            foreach ($binCodeDbKeys as $binCodeDbKey) {
                $fieldName = 'bin_'.strtolower($binCodeDbKey);
                $this->$fieldName = $binCodeInfo->$binCodeDbKey;
            }
            $this->bin_code = $binCodeInfo->bin;
        }

        if (isset($ipInfo)) {
            $ipDbKeys = IpApi::getDbKeys();
            foreach ($ipDbKeys as $ipDbKey) {
                $fieldName = 'bin_ip_'.strtolower($ipDbKey);
                $this->$fieldName = $ipInfo->$ipDbKey;
            }
        }
    }
}
