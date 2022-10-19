<?php

namespace Indianimmigrationorg\Repositories;
use Phalcon\Mvc\User\Component;

class Banner extends Component
{
    const CONTROLLER = 'controller';

    public static function getArrayController() {
        return array(
            self::CONTROLLER.'_index' => 'Home page',
            self::CONTROLLER.'_contactus' => 'Contact Us',
            self::CONTROLLER.'_faq' => 'Faq',
            self::CONTROLLER.'_embassy' => 'Embassy',
            self::CONTROLLER.'_checkrequirement' => 'Check Requirement',
            self::CONTROLLER.'_promotion' => 'Promotion',
        );
    }

    public function getControllerCombobox($controller_search){
        $arrController = self::getArrayController();
        $string = "<optgroup label=\"General\">";
        foreach($arrController as $controller => $title){
            $seleted = "";
            if($controller == $controller_search) {
                $seleted = "selected='selected'";
            }
            $string.="<option ".$seleted." value='".$controller."'>".$title."</option>";
        }
        $string .= '</optgroup>';
        return $string;
    }

    public static function getValue($value,$type)
    {
        $result = '';
        $arsValue = explode('_',$value);
        if(count($arsValue) === 2 && $arsValue[0] === $type) {
            $result = $arsValue[1];
        }
        return $result;
    }

    public static function getNameController($controller,$service)
    {

        $result = '';
        if (!empty(trim($controller))) {
            $result = isset(self::getArrayController()[$controller]) ? self::getArrayController()[$controller] : $controller;
        }
        return $result;
    }

    public static function getItem($controller,$service)
    {
        $result = "";
        if(!empty(trim($controller))){
            $result = self::CONTROLLER.'_'.$controller;
        }
        return $result;
    }


}