<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaVisaType;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;

class VisaType extends Component
{
    public static function findFirstById($id) {
        return VisaVisaType::findFirst([
            'type_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }
    public static function getIdDefault()
    {
        $id = 0;
        $type = VisaVisaType::findFirst("type_active='Y'");
        if($type){
            $id = $type->getTypeId();
        }
        return $id;
    }
    public static function getCombobox($ids)
    {
        $list_type = VisaVisaType::find("type_active='Y'");
        $arrID = explode(',',$ids);
        $output = '';
        foreach ($list_type as $type) {
            $selected = '';
            if (in_array($type->getTypeId(),$arrID)) {
                $selected = 'selected';
            }
            $output .= "<option " . $selected . " value='" . $type->getTypeId(). "'>" . $type->getTypeName() . "</option>";
        }
        return $output;
    }
}