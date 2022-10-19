<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Di;
use Indianimmigrationorg\Models\VisaCountry;
use Phalcon\Mvc\User\Component;

class Country extends Component
{

    public static function findFirstById($id)
    {
        return VisaCountry::findFirst(array(
            "country_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }


    public static function getHtml($type_id){
        $countries = VisaCountry::find("country_active='Y' AND country_value > 0");
        $output ='<div class="row">';
        foreach ($countries as $value)
        {
            $countryFee = GovernmentFee::findFirstById($type_id,$value->getCountryId());
            $fee = "";
            $note = "";
            if($countryFee){
                $fee = $countryFee->getFeeValue();
                $note = $countryFee->getFeeNote();
            }

            $output.= "<div class='col-md-4 text-right' style='padding-top:20px; display: flex; align-items: center;' >";
            $output.= "<div style='flex: 1 0 170px; padding-right: 15px'>" .$value->getCountryName(). "</div>";
            $output.="<input name='txtFee".$value->getCountryId()."' value='".$fee."' maxlength='10' value='".$fee."' class='form-control text-right' style='max-width:70px;'   >";
            $output.="<span class='add-on' style='background-color: #f5f5f5; height: 34px; display: flex; justify-content: center; align-items: center; padding: 5px; margin: 0 10px;'>USD</span>";
            $output.="<input name='txtNote".$value->getCountryId()."' value='".$note."'  placeholder='' class='form-control text-right'>";
            $output.= "</div> ";

        }
        $output .= "</div>";
        return $output;
    }
    //Function get String for type
    public static function getCombobox($countryId)
    {
        $list_country = VisaCountry::find(array(
            "country_value > 0",
            'order' => "country_name ASC"
        ));
        $string="";
        foreach($list_country as $country){
            $seleted="";
            if($country->getCountryId()==$countryId) {
                $seleted = 'selected="selected"';
            }
            $string.= '<option '.$seleted.' value="'.$country->getCountryId().'">'.$country->getCountryName().'</option>';
        }
        return $string;
    }
    public static function getNameById($id){
        $country = self::findFirstById($id);
        return ($country)?$country->getCountryName():"";
    }
}

