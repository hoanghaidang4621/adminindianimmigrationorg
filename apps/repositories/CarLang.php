<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaCarLang;

class CarLang extends Component
{
    public static  function deleteById($id){
        $arr_lang = self::findById($id);
        foreach ($arr_lang as $lang){
            $lang->delete();
        }
    }
    public static  function findFirstByIdAndLang($id,$lang_code){
        return VisaCarLang::findFirst(array (
            "car_id = :ID: AND car_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code )));
    }
    public static function findById($id) {
        return VisaCarLang::find([
            'car_id = :ID:',
            'bind' => array('ID' => $id),
        ]);
    }
}



