<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaCarFee;
use Phalcon\Mvc\User\Component;

class CarPickupFee extends Component
{
    public static function findFirstById($port_id,$car_id) {
        return VisaCarFee::findFirst([
            'port_id = :PortID: AND car_id = :CarID:',
            'bind' => ['PortID' => $port_id,'CarID' => $car_id]
        ]);
    }
    public static function getPortCarFee($port_id,$car_id){
        $result ="";
        $portfee = self::findFirstById($port_id,$car_id);
        if($portfee){
            $result = $portfee->getCarFee();
        }
        return $result;

    }

}