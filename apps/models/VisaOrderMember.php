<?php

namespace Indianimmigrationorg\Models;

class VisaOrderMember extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $member_id;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $member_order_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $member_name;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $member_country_id;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $member_gender;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=false)
     */
    protected $member_birthday;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $member_photo_file;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $member_passport_file;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $member_passport;

    /**
     *
     * @var integer
     * @Column(type="integer", nullable=true)
     */
    protected $member_visatype_id;

    /**
     *
     * @var double
     * @Column(type="double", nullable=true)
     */
    protected $member_visa_fee;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $member_given_name;

    /**
     *
     * @var double
     * @Column(type="double", nullable=false)
     */
    protected $member_government_fee;

    /**
     * Method to set the value of field member_id
     *
     * @param integer $member_id
     * @return $this
     */
    public function setMemberId($member_id)
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * Method to set the value of field member_order_id
     *
     * @param integer $member_order_id
     * @return $this
     */
    public function setMemberOrderId($member_order_id)
    {
        $this->member_order_id = $member_order_id;

        return $this;
    }

    /**
     * Method to set the value of field member_name
     *
     * @param string $member_name
     * @return $this
     */
    public function setMemberName($member_name)
    {
        $this->member_name = $member_name;

        return $this;
    }

    /**
     * Method to set the value of field member_country_id
     *
     * @param integer $member_country_id
     * @return $this
     */
    public function setMemberCountryId($member_country_id)
    {
        $this->member_country_id = $member_country_id;

        return $this;
    }

    /**
     * Method to set the value of field member_gender
     *
     * @param string $member_gender
     * @return $this
     */
    public function setMemberGender($member_gender)
    {
        $this->member_gender = $member_gender;

        return $this;
    }

    /**
     * Method to set the value of field member_birthday
     *
     * @param integer $member_birthday
     * @return $this
     */
    public function setMemberBirthday($member_birthday)
    {
        $this->member_birthday = $member_birthday;

        return $this;
    }

    /**
     * Method to set the value of field member_photo_file
     *
     * @param string $member_photo_file
     * @return $this
     */
    public function setMemberPhotoFile($member_photo_file)
    {
        $this->member_photo_file = $member_photo_file;

        return $this;
    }

    /**
     * Method to set the value of field member_passport_file
     *
     * @param string $member_passport_file
     * @return $this
     */
    public function setMemberPassportFile($member_passport_file)
    {
        $this->member_passport_file = $member_passport_file;

        return $this;
    }

    /**
     * Method to set the value of field member_passport
     *
     * @param string $member_passport
     * @return $this
     */
    public function setMemberPassport($member_passport)
    {
        $this->member_passport = $member_passport;

        return $this;
    }

    /**
     * Method to set the value of field member_visatype_id
     *
     * @param integer $member_visatype_id
     * @return $this
     */
    public function setMemberVisatypeId($member_visatype_id)
    {
        $this->member_visatype_id = $member_visatype_id;

        return $this;
    }

    /**
     * Method to set the value of field member_visa_fee
     *
     * @param double $member_visa_fee
     * @return $this
     */
    public function setMemberVisaFee($member_visa_fee)
    {
        $this->member_visa_fee = $member_visa_fee;

        return $this;
    }

    /**
     * Method to set the value of field member_given_name
     *
     * @param string $member_given_name
     * @return $this
     */
    public function setMemberGivenName($member_given_name)
    {
        $this->member_given_name = $member_given_name;

        return $this;
    }

    /**
     * Method to set the value of field member_government_fee
     *
     * @param double $member_government_fee
     * @return $this
     */
    public function setMemberGovernmentFee($member_government_fee)
    {
        $this->member_government_fee = $member_government_fee;

        return $this;
    }

    /**
     * Returns the value of field member_id
     *
     * @return integer
     */
    public function getMemberId()
    {
        return $this->member_id;
    }

    /**
     * Returns the value of field member_order_id
     *
     * @return integer
     */
    public function getMemberOrderId()
    {
        return $this->member_order_id;
    }

    /**
     * Returns the value of field member_name
     *
     * @return string
     */
    public function getMemberName()
    {
        return $this->member_name;
    }

    /**
     * Returns the value of field member_country_id
     *
     * @return integer
     */
    public function getMemberCountryId()
    {
        return $this->member_country_id;
    }

    /**
     * Returns the value of field member_gender
     *
     * @return string
     */
    public function getMemberGender()
    {
        return $this->member_gender;
    }

    /**
     * Returns the value of field member_birthday
     *
     * @return integer
     */
    public function getMemberBirthday()
    {
        return $this->member_birthday;
    }

    /**
     * Returns the value of field member_photo_file
     *
     * @return string
     */
    public function getMemberPhotoFile()
    {
        return $this->member_photo_file;
    }

    /**
     * Returns the value of field member_passport_file
     *
     * @return string
     */
    public function getMemberPassportFile()
    {
        return $this->member_passport_file;
    }

    /**
     * Returns the value of field member_passport
     *
     * @return string
     */
    public function getMemberPassport()
    {
        return $this->member_passport;
    }

    /**
     * Returns the value of field member_visatype_id
     *
     * @return integer
     */
    public function getMemberVisatypeId()
    {
        return $this->member_visatype_id;
    }

    /**
     * Returns the value of field member_visa_fee
     *
     * @return double
     */
    public function getMemberVisaFee()
    {
        return $this->member_visa_fee;
    }

    /**
     * Returns the value of field member_given_name
     *
     * @return string
     */
    public function getMemberGivenName()
    {
        return $this->member_given_name;
    }

    /**
     * Returns the value of field member_government_fee
     *
     * @return double
     */
    public function getMemberGovernmentFee()
    {
        return $this->member_government_fee;
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
        return 'visa_order_member';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderMember[]|VisaOrderMember
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaOrderMember
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
