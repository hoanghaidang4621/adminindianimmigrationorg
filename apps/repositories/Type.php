<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/9/2021
 * Time: 5:04 PM
 */

namespace Indianimmigrationorg\Repositories;
use Phalcon\Di;
use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaType;

class Type extends Component
{
    public static function checkKeyword($keyword, $id)
    {
        return VisaType::findFirst(array(
                'type_keyword = :keyword: AND type_id != :id: ',
                'bind' => array('keyword' => $keyword,
                    'id' => $id),
            )
        );
    }

    public static function getParentIdType($str = "", $parent=0, $inputslc)
    {
        $modelsManager = Di::getDefault()->get('modelsManager');
        $sql = 'SELECT type_id ,type_name FROM Indianimmigrationorg\Models\VisaType WHERE type_parent_id = :parentID: AND type_location_country_code = "gx" Order By type_order ASC';
        $data = $modelsManager->executeQuery($sql,
            array(
                "parentID" => $parent
            ));
        $output="";
        if (!is_array($inputslc)){
            $inputslc = [$inputslc];
        }
        foreach ($data as $key => $value)
        {
            $selected ="";
            if (in_array($value->type_id,$inputslc)) {
                $selected = "selected='selected'";
            }
            $output.= "<option ".$selected." value='".$value->type_id."'>".$str.$value->type_name."</option>";
            $output.= self::getParentIdType($str."----", $value->type_id, $inputslc);

        }
        return $output;
    }

    public static function getTypeNameById($id){
        $model = self::findFirstByIdAndLocationCountryCode($id,"gx");
        return $model ? $model->getTypeName() : '';

    }

    public static function findFirstByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaType::findFirst(array(
            'type_id = :id: AND type_location_country_code = :country_code:',
            'bind' => array('id' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findFirstById($id)
    {
        return VisaType::findFirst(array(
            "type_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
    public static function findById($id)
    {
        return VisaType::find(array(
            'type_id = :id:',
            'bind' => array('id' => $id),
        ));
    }
    public static function findFirstByParentId($typeId)
    {
        return VisaType::findFirst(array(
            "type_parent_id = :ID:",
            'bind' => array('ID' => $typeId)
        ));
    }
}