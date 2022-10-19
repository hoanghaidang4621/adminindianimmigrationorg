<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaVisaFee ;
use Phalcon\Mvc\User\Component;

class VisaFee extends Component
{
    public static function findFirstById($visa_type_id,$group_id) {
        return VisaVisaFee::findFirst([
            'visa_type_id = :TypeID: AND group_id = :GroupID:',
            'bind' => ['TypeID' => $visa_type_id,'GroupID' => $group_id]
        ]);
    }
    public static function getTypeGroupFee($visa_type_id,$group_id){
        $result ="";
        $gafee = self::findFirstById($visa_type_id,$group_id);
        if($gafee){
            $result = $gafee->getVisaFee();
        }
        return $result;

    }

}