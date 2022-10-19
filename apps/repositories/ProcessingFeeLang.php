<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaProcessingFeeLang;

class ProcessingFeeLang extends Component
{
    public static  function deleteById($id){
        $arr_lang = self::findById($id);
        foreach ($arr_lang as $lang){
            $lang->delete();
        }
    }
    public static  function findFirstByIdAndLang($id,$lang_code){
        return VisaProcessingFeeLang::findFirst(array (
            "processing_id = :ID: AND processing_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code )));
    }
    public static function findById($id) {
        return VisaProcessingFeeLang::find([
            'processing_id = :ID:',
            'bind' => array('ID' => $id),
        ]);
    }
}



