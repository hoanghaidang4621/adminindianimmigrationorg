<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaPromotionTemplate;
use Phalcon\Mvc\User\Component;

/**
 * Class EmailPromotionTemplate
 * @property \GlobalVariable globalVariable
 * @package Indianimmigrationorg\Repositories
 */
class PromotionTemplate extends Component {


    public static function findFirstById($id)
    {
        return VisaPromotionTemplate::findFirst(array(
            "template_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
    public static function findById($id)
    {
        return VisaPromotionTemplate::find(array(
            'template_id = :id:',
            'bind' => array('id' => $id),
        ));
    }

}
