<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaPageLang;

class PageLang extends Component
{
    public static function deleteById($id)
    {
        Page::findById($id)->delete();
        self::findById($id)->delete();
    }

    public static function deleteByIdAndLocationCountryCode($id, $country_code)
    {
        self::findByIdAndLocationCountryCode($id, $country_code)->delete();
    }

    public static function findFirstByIdAndLocationCountryCodeAndLang($id, $country_code, $lang_code)
    {
        return VisaPageLang::findFirst(array(
            "page_id = :ID: AND page_location_country_code = :country_code: AND page_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'country_code' => $country_code,
                'CODE' => $lang_code)));
    }
    public static function findByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaPageLang::find(array(
            "page_id =:ID: AND page_location_country_code = :country_code:",
            'bind' => array('ID' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findById($id)
    {
        return VisaPageLang::find(array(
            "page_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
}



