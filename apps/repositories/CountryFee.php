<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaCountryFee;
use Phalcon\Mvc\User\Component;

class CountryFee extends Component
{
    public static function findFirstById($visa_type_id,$country_id) {
        return VisaCountryFee::findFirst([
            'visa_type_id = :TypeID: AND country_id = :CountryID:',
            'bind' => ['TypeID' => $visa_type_id,'CountryID' => $country_id]
        ]);
    }
}