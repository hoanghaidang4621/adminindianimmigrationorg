<?php

namespace Indianimmigrationorg\Repositories;

use General\Models\Country;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

class CountryGeneral extends Component {

     public static function getNameByCode($code)
    {
        $result = self::getFirstByCode($code);
        return $result ? $result->getCountryName() : '';
    }
    public static function getFirstByCode($code)
    {
        return Country::findFirst(array(
            'country_iso_alpha2 = :code:',
            'bind'      => array('code' => $code),
        ));

    }
    public static function getComboboxByCode($code)
    {
        $jurisdiction = Country::find(array(
            'country_active = "Y" ',
            "order" => "country_name ASC",
        ));
        $output = '';
        $selected = '';
        if($code == "gx")
        {
            $selected = 'selected';
        }
        $output.= "<option ".$selected." value='gx'>GX - Global</option>";
        foreach ($jurisdiction as $value) {
            $selected = '';
            if ($value->getCountryIsoAlpha2() == $code) {
                $selected = 'selected';
            }
            $output .= "<option " . $selected . " value='" . $value->getCountryIsoAlpha2() . "'>" . $value->getCountryIsoAlpha2() . ' - ' . $value->getCountryName() . "</option>";

        }
        return $output;
    }
    public static function getCountryNameOrGlobalByCode($country_code)
    {
        $globalVariable = Di::getDefault()->get('globalVariable');
        if (strtolower($country_code) == $globalVariable->global['code']) {
            return $globalVariable->global['name'];
        }
        return self::getCountryNameByCode($country_code);
    }
    public static function getCountryNameByCode($country_code)
    {
        $result = Country::findFirst(array(
            'country_iso_alpha2 = :country_code:',
            'bind' => array('country_code' => $country_code)
        ));
        return ($result) ? $result->getCountryName() : '';
    }
    public static function findByCode($countryCode)
    {
        return Country::findFirst(array(
            "country_iso_alpha2=:countryCode: AND country_active='Y'",
            "bind" => array("countryCode" => $countryCode)
        ));
    }



}