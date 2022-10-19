<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaLocation;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

/**
 * @property \GlobalVariable globalVariable
 * @property \My my
 */
class Location extends Component
{
    public static function checkCode($country_code, $language_code, $id)
    {
        return VisaLocation::findFirst(
            array('location_country_code = :COUNTRY: AND location_lang_code = :LANGUAGE: AND location_id != :ID:',
                'bind' => array('COUNTRY' => $country_code,
                    'LANGUAGE' => $language_code,
                    'ID' => $id),
            ));
    }
    public static function findFirstById($locationId)
    {
        return VisaLocation::findFirst(array(
            "location_id =:ID:",
            'bind' => array('ID' => $locationId)
        ));
    }
    public static function getComboLocationLangByCode($code, $lang)
    {
        $globalVariable = new \GlobalVariable();
        $string = "";
        if (strtolower($code) == $globalVariable->global['code']) {
            $string = "<option selected value='" . $globalVariable->defaultLanguage . "'>" . strtoupper($globalVariable->defaultLanguage) . ' - ' . Language::getNameByCode($globalVariable->defaultLanguage) . "</option>";
        } $list_language = Location::findLocationLangByCode($code);
        foreach ($list_language as $language) {
            $selected = '';
            if ($language->getLocationLangCode() == $lang) {
                $selected = 'selected';
            }
            $string .= "<option " . $selected . " value='" . $language->getLocationLangCode() . "'>" . strtoupper($language->getLocationLangCode()) . ' - ' . Language::getNameByCode($language->getLocationLangCode()) . "</option>";
        }
        return $string;
    }
    public static function findLocationLangByCode($code)
    {
        return VisaLocation::find(array(
            'column' => 'location_lang_code',
            'conditions' => 'location_active = "Y" AND location_country_code = :CODE:',
            'bind' => array("CODE" => $code),
            'order' => 'location_order'
        ));
    }
    public static function arrLanguages($country_code)
    {
        $arr_language = array();
        $arr_language['en'] = "English";
        $list_language = self::findLanguageByCountryCode($country_code);
        foreach ($list_language as $language) {
            if ($language->getLanguageCode() != 'en') {
                $arr_language[$language->getLanguageCode()] = $language->getLanguageName();
            }
        }
        return $arr_language;
    }

    public static function findLanguageByCountryCode($country_code)
    {
        $modelsManager = Di::getDefault()->get('modelsManager');
        $sql = 'SELECT * FROM Indianimmigrationorg\Models\VisaLanguage WHERE language_code IN 
                    (SELECT location_lang_code FROM  Indianimmigrationorg\Models\VisaLocation WHERE  location_active= "Y" AND location_country_code = :country_code:)';
        $para['country_code'] = $country_code;
        return $modelsManager->executeQuery($sql, $para);
    }

    public static function getComboboxByLocationId($location_id,$location_from_id = 0) {
        $location_from_model = Location::findFirstById($location_from_id);
        $lang_from_code = "";
        if ($location_from_model) {
            $lang_from_code = $location_from_model->getLocationLangCode();
        }
        $arrLocation = self::findAllLocation($location_from_id,$lang_from_code);
        $combo_location = "";
        if (count($arrLocation) > 0) {
            foreach ($arrLocation as $location) {
                $selected = "";
                if ($location['location_id'] == $location_id) {
                    $selected = "selected";
                }
                $combo_location .= "<option ".$selected." value='".$location['location_id']."'>".
                    $location['country_name']." - ".$location['language_name']." 
                    (".strtoupper($location['location_country_code'])." / ".strtoupper($location['location_lang_code']).' )'."</option>";
            }
        }
        return $combo_location;
    }
    public static function findAllLocation($location_from_id,$lang_from_code)
    {
        $model = VisaLocation::query()->columns('location_id , location_country_code, location_lang_code, ct.country_name, lg.language_name')
            ->innerJoin('Indianimmigrationorg\Models\VisaCountry', 'LOWER(ct.country_code) = location_country_code', 'ct')
            ->innerJoin('Indianimmigrationorg\Models\VisaLanguage', 'LOWER(lg.language_code) = location_lang_code', 'lg')
            ->where('location_active = "Y" AND location_lang_code != "en" AND location_id != :location_from_id:',['location_from_id'=>$location_from_id]);
        if ($lang_from_code) {
            $model = $model->andWhere('location_lang_code = :lang_code:',['lang_code' => $lang_from_code]);
        }
        $model = $model->orderBy('ct.country_name, lg.language_name ASC')
            ->execute();
        return $model;
    }
    public static function getCountryGlobalComboBox($country_code)
    {
        $globalVariable = Di::getDefault()->get('globalVariable');
        $global = $globalVariable->global;
        $modelsManager = Di::getDefault()->get('modelsManager');
        $sql = 'SELECT * FROM \Indianimmigrationorg\Models\VisaCountry WHERE  country_code IN 
                    (SELECT DISTINCT location_country_code FROM  \Indianimmigrationorg\Models\VisaLocation WHERE location_active= "Y"  )';
        $list_country =  $modelsManager->executeQuery($sql)->toArray();
        $output = "";
        $selected = "";
        $code = strtoupper($global['code']);

        if ($country_code == 'all') {
            $selected = "selected = 'selected'";
        }
        $output .= "<option " . $selected . " value='all'> All Location Country </option>";
        $selected = "";
        if ($country_code == $code) {
            $selected = "selected = 'selected'";
        }
        $output .= "<option " . $selected . " value='" . $code . "'>" . strtoupper($global['code']) . ' - ' . $global['name'] . "</option>";
        foreach ($list_country as $country) {
            $selected = "";
            if ($country['country_code'] == $country_code) {
                $selected = "selected = 'selected'";

            }
            $output .= "<option " . $selected . " value='" . $country['country_code'] . "'>" . strtoupper($country['country_code']) . ' - ' . $country['country_name'] . "</option>";
        }
        return $output;
    }
    public static function getComboboxLanguage($lang_code)
    {
        $modelsManager = Di::getDefault()->get('modelsManager');
        $sql = 'SELECT lo.location_lang_code, la.language_name FROM \Indianimmigrationorg\Models\VisaLocation AS lo
                LEFT JOIN \Indianimmigrationorg\Models\VisaLanguage AS la 
                ON lo.location_lang_code = la.language_code 
                WHERE location_active= "Y" 
                GROUP BY location_lang_code
                ORDER BY location_order 
                ';
        $list_language =  $modelsManager->executeQuery($sql);
        $string = "";
        foreach ($list_language as $language) {
            $selected = '';
            if ($language->location_lang_code == $lang_code) {
                $selected = 'selected';
            }
            $string .= "<option " . $selected . " value='" . $language->location_lang_code . "'>" .strtoupper($language->location_lang_code). ' - ' . $language->language_name . "</option>";
        }
        return $string;
    }
}
