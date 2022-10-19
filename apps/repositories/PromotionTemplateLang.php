<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaPromotionTemplateLang;

class PromotionTemplateLang extends Component
{
    public static function deleteById($id)
    {
        EmailTemplate::findById($id)->delete();
        self::findById($id)->delete();
    }
    public static function findById($id)
    {
        return VisaPromotionTemplateLang::find(array(
            'template_id = :id:',
            'bind' => array('id' => $id),
        ));
    }
    public static function findFirstByIdAndLang($id, $lang_code)
    {
        return VisaPromotionTemplateLang::findFirst(array(
            " template_id = :ID: AND template_lang_code = :CODE: ",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code)));
    }
}