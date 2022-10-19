<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaExtraService;
use Phalcon\Mvc\User\Component;

class ExtraService extends Component
{
    public static function findFirstById($id) {
        return VisaExtraService::findFirst([
            'service_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }

}