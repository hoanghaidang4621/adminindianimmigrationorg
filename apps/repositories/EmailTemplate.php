<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaTemplateEmail;
use Phalcon\Mvc\User\Component;


class EmailTemplate extends Component {

    public static function checkKeyword($emailtemplate_type, $emailtemplate_id)
    {
        return VisaTemplateEmail::findFirst(
            array (
                'email_type = :type: AND email_id != :emailtemplateid:',
                'bind' => array('type' => $emailtemplate_type, 'emailtemplateid' => $emailtemplate_id),
            ));
    }
    public static function findFirstById($id)
    {
        return VisaTemplateEmail::findFirst(array(
            "email_id =:ID:",
            'bind' => array('ID' => $id)
        ));
    }
    public static function findById($id)
    {
        return VisaTemplateEmail::find(array(
            'email_id = :id:',
            'bind' => array('id' => $id),
        ));
    }

}
