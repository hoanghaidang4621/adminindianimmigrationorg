<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaLanguage;
use Phalcon\Mvc\User\Component;

class Language extends Component
{

    public static function checkCode($language_code, $language_id)
    {
        return VisaLanguage::findFirst(
            array(
                'language_code = :CODE: AND language_id != :languageid:',
                'bind' => array('CODE' => $language_code, 'languageid' => $language_id),
            ));
    }

    /**
     * @return VisaLanguage|VisaLanguage[]
     */
    public static function getLanguages()
    {
        return VisaLanguage::find(array("language_active = 'Y'",
            "order" => "language_code"));
    }
    public static function getLanguagesNotActive()
    {
        return VisaLanguage::find(array("order" => "language_code"));
    }
    public static function arrLanguages()
    {
        $arr_language = array();
        $arr_language['en'] = "English";
        $languages = self::getLanguages();
        foreach ($languages as $lang) {
            if ($lang->getLanguageCode() != 'en') {
                $arr_language[$lang->getLanguageCode()] = $lang->getLanguageName();
            }
        }
        return $arr_language;
    }


    public static function getNameByCode($language_code)
    {
        $tn_language = VisaLanguage::findFirst(array('language_code = :CODE: AND language_active="Y"', 'bind' => array('CODE' => $language_code),));
        return $tn_language ? $tn_language->getLanguageName() : '';
    }
    public static function getComboLanguage($lang_code)
    {
        $list_language = self::getLanguagesNotActive();

        $string = "";
        foreach ($list_language as $language) {
            $selected = '';
            if (strtoupper($language->getLanguageCode()) == $lang_code) {
                $selected = 'selected';
            }
            $string .= "<option " . $selected . " value='" . $language->getLanguageCode() . "'>" . $language->getLanguageName() . "</option>";
        }
        return $string;
    }
    public static function getCombo($lang_code)
    {
        $list_language = self::getLanguages();

        $string = "";
        foreach ($list_language as $language) {
            $selected = '';
            if ($language->getLanguageCode() == $lang_code) {
                $selected = 'selected';
            }
            $string .= "<option " . $selected . " value='" . $language->getLanguageCode() . "'>" . strtoupper($language->getLanguageCode()) . ' - ' . $language->getLanguageName() . "</option>";
        }
        return $string;
    }
    public static function findFirstById($languageId)
    {
        return VisaLanguage::findFirst(array(
            "language_id =:ID:",
            'bind' => array('ID' => $languageId)
        ));
    }
    public static function getIsTranslateKeyword($language_code) {
        $tn_language = VisaLanguage::findFirst(array('language_code = :CODE: AND language_active="Y"', 'bind' => array('CODE' => $language_code),));
        return $tn_language ? $tn_language->getLanguageIsTranslateKeyword() : '';
    }
}
