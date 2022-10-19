<?php

namespace Indianimmigrationorg\Models;

class VisaVisaType extends BaseModel
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    protected $type_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    protected $type_icon;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $type_group_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    protected $type_name;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $type_description;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $type_ineligible_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $type_required_content;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $type_document_requirement;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    protected $type_order;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    protected $type_active;

    /**
     * Method to set the value of field type_id
     *
     * @param integer $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Method to set the value of field type_icon
     *
     * @param string $type_icon
     * @return $this
     */
    public function setTypeIcon($type_icon)
    {
        $this->type_icon = $type_icon;

        return $this;
    }

    /**
     * Method to set the value of field type_group_name
     *
     * @param string $type_group_name
     * @return $this
     */
    public function setTypeGroupName($type_group_name)
    {
        $this->type_group_name = $type_group_name;

        return $this;
    }

    /**
     * Method to set the value of field type_name
     *
     * @param string $type_name
     * @return $this
     */
    public function setTypeName($type_name)
    {
        $this->type_name = $type_name;

        return $this;
    }

    /**
     * Method to set the value of field type_description
     *
     * @param string $type_description
     * @return $this
     */
    public function setTypeDescription($type_description)
    {
        $this->type_description = $type_description;

        return $this;
    }

    /**
     * Method to set the value of field type_ineligible_content
     *
     * @param string $type_ineligible_content
     * @return $this
     */
    public function setTypeIneligibleContent($type_ineligible_content)
    {
        $this->type_ineligible_content = $type_ineligible_content;

        return $this;
    }

    /**
     * Method to set the value of field type_required_content
     *
     * @param string $type_required_content
     * @return $this
     */
    public function setTypeRequiredContent($type_required_content)
    {
        $this->type_required_content = $type_required_content;

        return $this;
    }

    /**
     * Method to set the value of field type_document_requirement
     *
     * @param string $type_document_requirement
     * @return $this
     */
    public function setTypeDocumentRequirement($type_document_requirement)
    {
        $this->type_document_requirement = $type_document_requirement;

        return $this;
    }

    /**
     * Method to set the value of field type_order
     *
     * @param integer $type_order
     * @return $this
     */
    public function setTypeOrder($type_order)
    {
        $this->type_order = $type_order;

        return $this;
    }

    /**
     * Method to set the value of field type_active
     *
     * @param string $type_active
     * @return $this
     */
    public function setTypeActive($type_active)
    {
        $this->type_active = $type_active;

        return $this;
    }

    /**
     * Returns the value of field type_id
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Returns the value of field type_icon
     *
     * @return string
     */
    public function getTypeIcon()
    {
        return $this->type_icon;
    }

    /**
     * Returns the value of field type_group_name
     *
     * @return string
     */
    public function getTypeGroupName()
    {
        return $this->type_group_name;
    }

    /**
     * Returns the value of field type_group_name
     *
     * @return string
     */
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * Returns the value of field type_description
     *
     * @return string
     */
    public function getTypeDescription()
    {
        return $this->type_description;
    }

    /**
     * Returns the value of field type_ineligible_content
     *
     * @return string
     */
    public function getTypeIneligibleContent()
    {
        return $this->type_ineligible_content;
    }

    /**
     * Returns the value of field type_required_content
     *
     * @return string
     */
    public function getTypeRequiredContent()
    {
        return $this->type_required_content;
    }

    /**
     * Returns the value of field type_document_requirement
     *
     * @return string
     */
    public function getTypeDocumentRequirement()
    {
        return $this->type_document_requirement;
    }

    /**
     * Returns the value of field type_order
     *
     * @return integer
     */
    public function getTypeOrder()
    {
        return $this->type_order;
    }

    /**
     * Returns the value of field type_active
     *
     * @return string
     */
    public function getTypeActive()
    {
        return $this->type_active;
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
        return 'visa_visa_type';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaVisaType[]|VisaVisaType
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VisaVisaType
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
