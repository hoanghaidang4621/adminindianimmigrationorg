<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaGroupApplicantLang;

class GroupApplicantLang extends Component
{
    public static  function deleteById($id){
        $arr_lang = self::findById($id);
        foreach ($arr_lang as $lang){
            $lang->delete();
        }
    }
    public static  function findFirstByIdAndLang($id,$lang_code){
        return VisaGroupApplicantLang::findFirst(array (
            "group_id = :ID: AND group_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code )));
    }
    public static function findById($id) {
        return VisaGroupApplicantLang::find([
            'group_id = :ID:',
            'bind' => array('ID' => $id),
        ]);
    }
}



