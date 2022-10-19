<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/9/2021
 * Time: 5:04 PM
 */

namespace Indianimmigrationorg\Repositories;
use Phalcon\Mvc\User\Component;
use Indianimmigrationorg\Models\VisaArticle;

class Article extends Component
{
    public static function checkKeyword($keyword, $id)
    {
        return VisaArticle::findFirst(array(
                'article_keyword = :keyword: AND article_id != :id: ',
                'bind' => array('keyword' => $keyword,
                    'id' => $id),
            )
        );
    }
    public static function findFirstByIdAndLocationCountryCode($id, $country_code)
    {
        return VisaArticle::findFirst(array(
            'article_id = :id: AND article_location_country_code = :country_code:',
            'bind' => array('id' => $id, 'country_code' => $country_code)
        ));
    }
    public static function findFirstByType($type) {
        return VisaArticle::findFirst([
            'article_type_id = :type:',
            'bind' => ['type'=> $type]
        ]);
    }
    public static function findById($id)
    {
        return VisaArticle::find(array(
            'article_id = :id:',
            'bind' => array('id' => $id),
        ));
    }
    public static function findFirstById($id)
    {
        return VisaArticle::findFirst(array(
            'article_id = :id:',
            'bind' => array('id' => $id),
        ));
    }
    public static function getComboboxStatus($status_selected)
    {
        $list_status = ['required', 'exempt', 'not-eligible'];
        $output = '';
        foreach ($list_status as $status) {
            $selected = '';
            if ($status == $status_selected) {
                $selected = 'selected';
            }
            $output .= "<option " . $selected . " value='" . $status. "'>" . $status . "</option>";
        }
        return $output;
    }

}