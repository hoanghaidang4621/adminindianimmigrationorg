<?php

namespace Indianimmigrationorg\Repositories;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;
use Visacorp\Models\UserSiteInfo;


class UserSiteInfoCorp extends Component
{
    public static function findFirstByUserSite($user_id, $site_id){
        return UserSiteInfo ::findFirst(array(
            'user_id = :user_id: AND user_site_id = :site_id:',
            'bind' => array('user_id' => $user_id,'site_id' =>$site_id)
        ));
    }
    public static function insertUserSiteInfo($user_id,$site_id){
        $userSiteInfo = self::findFirstByUserSite($user_id,$site_id);
        if(!$userSiteInfo){
            $new_user_info = new UserSiteInfo();
            $new_user_info->setUserId($user_id);
            $new_user_info->setUserSiteId($site_id);
            $new_user_info->setUserIsSubscribe('Y');
            $new_user_info->setUserInsertTime(time());
            $new_user_info->save();
        }
    }
    public static function findIdByEmail($email){
        $sql = "SELECT u.user_id FROM Visacorp\Models\UserCorp u
              INNER JOIN Visacorp\Models\UserSiteInfo i  ON i.user_id = u.user_id AND i.user_site_id = :siteID:
              WHERE u.user_email LIKE CONCAT('%',:email:,'%') ";
        $globalVariable = Di::getDefault()->get('globalVariable');
        $modelsManager = Di::getDefault()->get('modelsManager');
        $list_user =  $modelsManager->executeQuery($sql,['siteID' => $globalVariable->site_id,'email' => $email])->toArray();
        $arrUserID = array_values(array_column($list_user, 'user_id'));
        $arrUserID = array_merge([-1], $arrUserID);
        return $arrUserID;
    }
}



