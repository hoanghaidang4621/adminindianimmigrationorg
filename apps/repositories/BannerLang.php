<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaBannerLang;
use Phalcon\Mvc\User\Component;

class BannerLang extends Component
{
    public static function deleteById($id)
    {
        VisaBannerLang::findById($id)->delete();
    }

    public static function findFirstByIdAndLang($id, $lang_code)
    {
        return VisaBannerLang::findFirst(array(
            "banner_id = :ID: AND banner_lang_code = :CODE:",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code)));
    }
}