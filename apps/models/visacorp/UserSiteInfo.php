<?php

namespace Visacorp\Models;

class UserSiteInfo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    protected $user_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=4, nullable=false)
     */
    protected $user_site_id;

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
    protected $user_is_subscribe;


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
     * Method to set the value of field user_site_id
     *
     * @param integer $user_site_id
     * @return $this
     */
    public function setUserSiteId($user_site_id)
    {
        $this->user_site_id = $user_site_id;

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
     * Method to set the value of field user_is_subscribe
     *
     * @param string $user_is_subscribe
     * @return $this
     */
    public function setUserIsSubscribe($user_is_subscribe)
    {
        $this->user_is_subscribe = $user_is_subscribe;

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
     * Returns the value of field user_site_id
     *
     * @return integer
     */
    public function getUserSiteId()
    {
        return $this->user_site_id;
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
     * Returns the value of field user_is_subscribe
     *
     * @return string
     */
    public function getUserIsSubscribe()
    {
        return $this->user_is_subscribe;
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
        return 'user_site_info';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserSiteInfo[]|UserSiteInfo
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserSiteInfo
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param integer $id
     * @param integer $site_id
     * @return UserSiteInfo
     */
    public static function findFirstById($id, $site_id)
    {
        return UserSiteInfo::findFirst(array(
            'user_id = :ID: AND user_site_id = :Siteid:',
            'bind' => array('ID' => $id, 'Siteid' => $site_id)
        ));
    }
    public  static function getCount($site_id){
        return UserSiteInfo::count(array(
            'user_site_id = :site_id:',
            'bind' => array('site_id'=> $site_id)
        ));
    }

    public static function findUserBySiteId($site_id)
    {
        $userSiteInfo = UserSiteInfo::find(array(
            'columns' => 'user_id',
            'user_site_id = :SiteId:',
            'bind' => array('SiteId' => $site_id)
        ))->toArray();
        return array_column($userSiteInfo,'user_id');
    }
}
