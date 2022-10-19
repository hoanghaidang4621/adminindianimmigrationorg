<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaGovernmentFee ;
use Phalcon\Mvc\User\Component;

class GovernmentFee extends Component
{
    public static function findFirstById($visa_type_id,$country_id) {
        return VisaGovernmentFee::findFirst([
            'fee_visatype_id = :TypeID: AND fee_country_id = :CountryID:',
            'bind' => ['TypeID' => $visa_type_id,'CountryID' => $country_id]
        ]);
    }
}