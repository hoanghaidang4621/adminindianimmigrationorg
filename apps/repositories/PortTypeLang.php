<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaPortTypeLang;

class PortTypeLang extends Component
{
    public static  function deleteById($id){
        $arr_lang = self::findById($id);
        foreach ($arr_lang as $lang){
            $lang->delete();
        }
    }
    public static  function findFirstByIdAndLang($id,$lang_code){
        return VisaPortTypeLang::findFirst(array (
            "type_id = :ID: AND type_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code )));
    }
    public static function findById($id) {
        return VisaPortTypeLang::find([
            'type_id = :ID:',
            'bind' => array('ID' => $id),
        ]);
    }
}



