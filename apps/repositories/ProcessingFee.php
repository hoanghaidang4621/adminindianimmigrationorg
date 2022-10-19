<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaProcessingFee;
use Phalcon\Mvc\User\Component;

class ProcessingFee extends Component
{
    public static function findFirstById($id) {
        return VisaProcessingFee::findFirst([
            'processing_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }

}