<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaArticleLang;

class ArticleLang extends Component
{
    public static function deleteById($id)
    {
        Article::findById($id)->delete();
        self::findById($id)->delete();
    }

    public static function deleteByIdAndLocationCountryCode($id, $country_code)
    {
        self::findByIdAndLocationCountryCode($id, $country_code)->delete();
    }

    public static function findFirstByIdAndLocationCountryCodeAndLang($id, $country_code, $lang_code)
    {
        return VisaArticleLang::findFirst(array(
            "article_id = :ID: AND article_location_country_code = :country_code: AND article_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'country_code' => $country_code,
                'CODE' => $lang_code)));
    }
    public static function findByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaArticleLang::find(array(
            "article_id =:ID: AND article_location_country_code = :country_code:",
            'bind' => array('ID' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findById($id)
    {
        return VisaArticleLang::find(array(
            "article_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
    public static function findFirstById($id) {
        return VisaArticleLang::findFirst([
            "article_id =:ID:",
            'bind' => array('ID' => $id)
        ]);
    }
}



