<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaPortType ;
use Phalcon\Mvc\User\Component;

class PortType extends Component
{
    public static function findFirstById($id) {
        return VisaPortType::findFirst([
            'type_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }
    public static function getCombobox($id)
    {
        $list_port_type = VisaPortType::find();
        $output = '';
        foreach ($list_port_type as $port_type) {
            $selected = '';
            if ($port_type->getTypeId() == $id) {
                $selected = 'selected';
            }
            $output .= "<option " . $selected . " value='" . $port_type->getTypeId(). "'>" . $port_type->getTypeName() . "</option>";

        }
        return $output;
    }
    public static function getNameById($id)
    {

        $result = self::findFirstById($id);
        return ($result) ? $result->getTypeName() : '';
    }

}