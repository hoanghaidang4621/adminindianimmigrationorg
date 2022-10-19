<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaCountryLang;

class CountryLang extends Component
{
    public static function deleteById($id)
    {
        $arr_lang = VisaCountryLang::findById($id);
        foreach ($arr_lang as $lang) {
            $lang->delete();
        }
    }
    public static function findFirstByIdAndLang($id, $lang_code)
    {
        return VisaCountryLang::findFirst(array(
            "country_id = :ID: AND country_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code)));
    }    
}