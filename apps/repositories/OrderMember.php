<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaOrderMember;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

class OrderMember extends Component
{
    public static function getArrOrderIdByCountry($txt_search_country)
    {
        $sql_search = "SELECT DISTINCT member_order_id FROM Indianimmigrationorg\Models\VisaOrderMember
                            WHERE member_country_id =:COUNTRY:";
        $modelsManager = Di::getDefault()->get('modelsManager');
        $details = $modelsManager->executeQuery($sql_search, array("COUNTRY" => $txt_search_country));
        $arrOrderId = array_values(array_column($details->toArray(), 'member_order_id'));
        $arrOrderId = array_merge([-1], $arrOrderId);
        return $arrOrderId;
    }
    //find member by order id
    public static function findByOrderID($orderID)
    {
        return VisaOrderMember::find(array(
            "member_order_id = :orderID:",
            "bind" => array("orderID" => $orderID)
        ));
    }
    /** @return VisaOrderMember */
    public static function getGovernmentFeeByOrderId($orderID)
    {
        return VisaOrderMember::find([
            "member_order_id = :orderID: AND member_government_fee >0  ",
            "bind" => array("orderID" => $orderID)
        ]);
    }
    public static function getGender(){
        return ['Y'=>"Male",'N'=>'Female','O'=>'Other'];
    }
    public static function getGenderName($gender){
        $genders = self::getGender();
        return isset($genders[$gender])?$genders[$gender]:'';
    }
}