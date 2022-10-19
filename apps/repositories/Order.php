<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaOrder;
use Phalcon\Mvc\User\Component;

class Order extends Component
{
    public static function getMethodCombobox($method_search){
        $arrMethod=array("Credit/Debit Card","PayPal","Bank Transfer","Credit/Debit Card (Stripe)","Credit/Debit Card (CyberSource)");
        $string="<option  value=''>All Method</option>";
        foreach($arrMethod as $method){
            $seleted = "";
            if($method==$method_search) {
                $seleted = "selected='selected'";
            }
            $string.="<option ".$seleted." value='".$method."'>".$method."</option>";
        }
        return $string;

    }
    public static function getStatusCombobox($status_search){
        $arrStatus=array("Success","Pending","Cancel","Fail");
        $string="<option  value=''>All Status</option>";
        foreach($arrStatus as $status){
            $seleted = "";
            if($status==$status_search) {
                $seleted = "selected='selected'";
            }
            $string.="<option ".$seleted." value='".$status."'>".$status."</option>";
        }
        return $string;
    }
    public  static function findFirstById($id){
        return VisaOrder::findFirst(array(
            'order_id = :order_id: ',
            'bind' => array('order_id' => $id)
        ));
    }
}