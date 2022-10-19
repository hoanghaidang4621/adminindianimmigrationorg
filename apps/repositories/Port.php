<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaPort ;
use Phalcon\Mvc\User\Component;

class Port extends Component
{
    public static function findFirstById($id) {
        return VisaPort::findFirst([
            'port_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }
    public static function getIdDefault()
    {
        $id = 0;
        $port = VisaPort::findFirst("port_active='Y'");
        if($port){
            $id = $port->getPortId();
        }
        return $id;
    }
}