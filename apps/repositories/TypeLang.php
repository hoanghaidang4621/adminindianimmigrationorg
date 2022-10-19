<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaTypeLang;

class TypeLang extends Component
{
    public static function deleteById($id)
    {
        Type::findById($id)->delete();
        self::findById($id)->delete();
    }

    public static function deleteByIdAndLocationCountryCode($id, $country_code)
    {
        self::findByIdAndLocationCountryCode($id, $country_code)->delete();
    }

    public static function findFirstByIdAndLocationCountryCodeAndLang($id, $country_code, $lang_code)
    {
        return VisaTypeLang::findFirst(array(
            "type_id = :ID: AND type_location_country_code = :country_code: AND type_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'country_code' => $country_code,
                'CODE' => $lang_code)));
    }
    public static function findFirstByIdAndLang($id, $lang_code, $location_code = 'gx')
    {

        return VisaTypeLang::findFirst(array(
            " type_id = :ID: AND type_lang_code = :CODE: AND type_location_country_code=:location_code:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code,
                'location_code' => $location_code)));
    }
    public static function findByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaTypeLang::find(array(
            "type_id =:ID: AND type_location_country_code = :country_code:",
            'bind' => array('ID' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findById($id)
    {
        return VisaTypeLang::find(array(
            "type_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
}



