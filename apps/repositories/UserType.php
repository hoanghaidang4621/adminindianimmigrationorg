<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Visacorp\Models\TypeUser;

class UserType extends Component
{
    public  static function findFirstById($id){
        return TypeUser::findFirst(array(
            'typeuser_id = :id: ',
            'bind' => array('id' => $id)
        ));
    }
    public static function getNameById($id){
        $user = self::findFirstById($id);
        return ($user)?$user->getTypeuserName():'New level';
    }
}

