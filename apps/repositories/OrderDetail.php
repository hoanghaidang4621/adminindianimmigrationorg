<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaOrderDetail;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

class OrderDetail extends Component
{
    public static function getArrOrderIdByService($service_id)
    {
        $sql_search = "SELECT DISTINCT order_id FROM Indianimmigrationorg\Models\VisaOrderDetail
                            WHERE order_service_id =:service_id:";
        $modelsManager = Di::getDefault()->get('modelsManager');
        $details = $modelsManager->executeQuery($sql_search, array("service_id" => $service_id));
        $arrOrderId = array_values(array_column($details->toArray(), 'order_id'));
        $arrOrderId = array_merge([-1], $arrOrderId);
        return $arrOrderId;
    }
    public static function findByOrder($order_id){
        return VisaOrderDetail::find([
            'order_id = :ORDER_ID: ',
            'bind' => ['ORDER_ID'=> $order_id]
        ]);
    }
}