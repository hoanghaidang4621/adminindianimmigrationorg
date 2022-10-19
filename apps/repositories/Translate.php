<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
class Translate extends Component
{
    //return array column special of array column
    public static function getColumnSpecial($columnModel,$columnModelLang)
    {
        $arrColumn = array(
            'columnId' => "",
            'columnLang' => "",
            'columnActive' => "",
            'columnLocationCountryCode' => "",
            'columnSeo' => "",
            'columnCountry' => "",
            'columnKeyword' => "",
            'columnName' => ""
        );
        $arrColumn['columnId'] = reset($columnModel);

        foreach ($columnModelLang as $column) {
            if (strpos($column, 'lang_code') || $column == "lang_code") {
                $arrColumn['columnLang'] = $column;
            }
        }
        foreach ($columnModel as $column) {
            if (strpos($column, '_active')) {
                $arrColumn['columnActive'] = $column;
            }
            if (strpos($column, '_location_country_code') && in_array($column,$columnModelLang)) {
                $arrColumn['columnLocationCountryCode'] = $column;
            }
            if (strpos($column, '_seo') && in_array($column, $columnModelLang)) {
                $arrColumn['columnSeo'] = $column;
            }
            if (strpos($column, '_country_code') && !strpos($column, '_location_country_code') && !strpos($column, '_jurisdiction_country_code')) {
                $arrColumn['columnCountry'] = $column;
            }

            if (strpos($column, '_keyword') && !strpos($column, '_meta_keyword')) {
                $arrColumn['columnKeyword'] = $column;
            }
            if (strpos($column, '_name') && empty($arrColumn['columnName'])) {
                $arrColumn['columnName'] = $column;
            }

        }
        return $arrColumn;
    }
}