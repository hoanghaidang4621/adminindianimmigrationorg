<?php

namespace Indianimmigrationorg\Repositories;

use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaTemplateEmailLang;

class EmailTemplateLang extends Component
{
    public static function deleteById($id)
    {
        EmailTemplate::findById($id)->delete();
        self::findById($id)->delete();
    }
    public static function findById($id)
    {
        return VisaTemplateEmailLang::find(array(
            'email_id = :id:',
            'bind' => array('id' => $id),
        ));
    }
    public static function findFirstByIdAndLang($id, $lang_code)
    {
        return VisaTemplateEmailLang::findFirst(array(
            " email_id = :ID: AND email_lang_code = :CODE: ",
            'bind' => array('ID' => $id,
                'CODE' => $lang_code)));
    }

}