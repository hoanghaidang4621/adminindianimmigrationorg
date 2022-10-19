<?php

namespace Indianimmigrationorg\Backend\Controllers;


use Indianimmigrationorg\Repositories\Translate;

class CopydataController extends ControllerBase
{
    public function insertVNAction() {
        $idInput = $this->request->get('id');
        $tableInput = $this->request->get('tableName');
        $response = [];
        $arrayTable = $array_table = self::allTableLocation();
        if (isset($arrayTable[$tableInput])) {
            $arrayTableLang = self::allTableLocation('lang');
            // array column model lang
            $arrayColumnModelLang = array_keys((new $arrayTableLang[$tableInput.'_lang'])->toArray());

            $column_models = array_keys((new $arrayTable[$tableInput])->toArray());

            $arrColumnSpecial = Translate::getColumnSpecial($column_models,$arrayColumnModelLang);

            $column_lang_code = $arrColumnSpecial['columnLang'];
            $column_location_country_lang = $arrColumnSpecial['columnLocationCountryCode'];
            $column_id = $arrColumnSpecial['columnId'];

        } else {
            $response = [
                'status' => false,
                'messages' => 'table: '.$idInput ." not is table seo",
            ];
            die(json_encode($response));
        }

        if (!empty($column_location_country_lang)) {
            $model_gx = $arrayTable[$tableInput]::findFirst(array(
                "$column_location_country_lang = 'gx' AND $column_id = :ID:",
                "bind" => ['ID' => $idInput]
            ));
            if (!$model_gx) {
                $response =  [
                    'status' => false,
                    'messages' => 'not found model "gx" id:'.$idInput,
                ];
                die(json_encode($response));
            }
            $data_gx = $model_gx->toArray();
            $model_vn_en = $arrayTable[$tableInput]::findFirst(array(
                "$column_location_country_lang = 'vn' AND $column_id = :ID:",
                "bind" => ['ID' => $idInput]
            ));
            if (!$model_vn_en) {
                $model_vn_en = new $arrayTable[$tableInput];
                $data_gx[$column_location_country_lang] = 'vn';
                $results = $model_vn_en->save($data_gx);
                if ($results) {
                    $response['messages'] = 'insert VN / EN success, ';
                }
            } else {
                $response['messages'] = 'record VN / EN is exist, ';
            }

            $modelLang = $arrayTable[$tableInput] . 'Lang';
            $model_vn_vi = $modelLang::findFirst(array(
                "$column_location_country_lang = 'vn' AND $column_id = :ID: AND $column_lang_code ='vi'",
                "bind" => ['ID' => $idInput]
            ));
            if (!$model_vn_vi) {
                $model_vn_vi = new $modelLang;
                $data_gx[$column_lang_code] = 'vi';
                $data_gx[$column_location_country_lang] = 'vn';
                $results_lang = $model_vn_vi->save($data_gx);
                if ($results_lang) {
                    $response['messages'].= 'insert VN / VI success ';
                }
            } else {
                $response['messages'].= 'record VN / VI is exist ';
            }
        }
        $response['status'] = true;
        die(json_encode($response));
    }
    private function allTableLocation($type = '')
    {
        $arrayTable = array(
            'visa_article' => 'Indianimmigrationorg\Models\VisaArticle',
            'visa_type' => 'Indianimmigrationorg\Models\VisaType',
            'visa_page' => 'Indianimmigrationorg\Models\VisaPage',
              );
        $arrayTableLang = array(
            'visa_article_lang' => 'Indianimmigrationorg\Models\VisaArticleLang',
            'visa_type_lang' => 'Indianimmigrationorg\Models\VisaTypeLang',
            'visa_page_lang' => 'Indianimmigrationorg\Models\VisaPageLang',
        );
        $response = $arrayTable;
        if ($type == 'full') {
            $response = array_merge($arrayTable, $arrayTableLang);
        } elseif ($type == 'lang') {
            $response = $arrayTableLang;
        } elseif ($type == "notlang") {
            return $response;
        }
        return $response;
    }
}