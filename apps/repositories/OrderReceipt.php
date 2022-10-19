<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaReceipt;
use Phalcon\Mvc\User\Component;

class OrderReceipt extends Component
{

    public  static function findFirstByOrder($id){
        return VisaReceipt::findFirst(array(
            'receipt_order_id = :order_id: ',
            'bind' => array('order_id' => $id)
        ));
    }
}