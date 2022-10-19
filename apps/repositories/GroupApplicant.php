<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaGroupApplicant ;
use Phalcon\Mvc\User\Component;

class GroupApplicant extends Component
{
    public static function findFirstById($id) {
        return VisaGroupApplicant::findFirst([
            'group_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }

}