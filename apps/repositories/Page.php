<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Models\VisaPage;
use Phalcon\Mvc\User\Component;

class Page extends Component
{
    public static function checkKeyword($keyword, $id)
    {
        return VisaPage::findFirst(array(
                'page_keyword = :keyword: AND page_id != :id: ',
                'bind' => array('keyword' => $keyword,
                    'id' => $id),
            )
        );
    }
    public static function findFirstByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaPage::findFirst(array(
            'page_id = :id: AND page_location_country_code = :country_code:',
            'bind' => array('id' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findById($id)
    {
        return VisaPage::find(array(
            'page_id = :id:',
            'bind' => array('id' => $id),
        ));
    }

}
