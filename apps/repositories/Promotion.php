<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaPromotion ;
use Phalcon\Mvc\User\Component;

class Promotion extends Component
{
    public static function findFirstById($id) {
        return VisaPromotion::findFirst([
            'promotion_id = :id:',
            'bind' => ['id'=> $id]
        ]);
    }
    public static function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function checkCode($code,$id)
    {
        return VisaPromotion::findFirst(
            [
                'promotion_code = :code: AND promotion_id != :id:',
                'bind'      => array('code' => $code,'id' => $id),
            ]
        );
    }
}