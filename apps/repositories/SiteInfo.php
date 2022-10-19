<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Visacorp\Models\UserSiteInfo;

class SiteInfo extends Component
{
    public  static function findFirstById($id,$site_id){
        return UserSiteInfo::findFirst(array(
            'user_id = :user_id: AND user_site_id = :user_site_id:',
            'bind' => array('user_id' => $id,'user_site_id' => $site_id)
        ));
    }
}

