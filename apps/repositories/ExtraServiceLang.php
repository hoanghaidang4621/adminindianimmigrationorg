<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaExtraServiceLang;

class ExtraServiceLang extends Component
{
    public static  function deleteById($id){
        $arr_lang = self::findById($id);
        foreach ($arr_lang as $lang){
            $lang->delete();
        }
    }
    public static  function findFirstByIdAndLang($id,$lang_code){
        return VisaExtraServiceLang::findFirst(array (
            "service_id = :ID: AND service_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code )));
    }
    public static function findById($id) {
        return VisaExtraServiceLang::find([
            'service_id = :ID:',
            'bind' => array('ID' => $id),
        ]);
    }
}



