<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaFastTrackFee;
use Phalcon\Mvc\User\Component;

class FastTrackFee extends Component
{
    public static function findFirstById($port_id,$group_id) {
        return VisaFastTrackFee::findFirst([
            'port_id = :PortID: AND group_id = :GroupID:',
            'bind' => ['PortID' => $port_id,'GroupID' => $group_id]
        ]);
    }
    public static function getPortGroupFee($port_id,$group_id){
        $result ="";
        $portfee = self::findFirstById($port_id,$group_id);
        if($portfee){
            $result = $portfee->getFastCheckFee();
        }
        return $result;

    }

}