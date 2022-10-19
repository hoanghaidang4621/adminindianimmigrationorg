<?php
namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLocation;
use Indianimmigrationorg\Repositories\Country;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\Location;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class LocationController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->get('page');

        $validator = new Validator();
        if($validator->validInt($current_page) == false || $current_page < 1)
            $current_page=1;
        $country = strtolower($this->request->get('slCountry'));
        $lang_code = strtolower($this->request->get('slLanguage'));
        $active = $this->request->get('slcActive');

        $sql = "SELECT DISTINCT l.* 
                FROM Indianimmigrationorg\Models\VisaLocation as l
                LEFT JOIN Indianimmigrationorg\Models\VisaCountry as c
                ON l.location_country_code = c.country_code
                WHERE 1";
        $arrParameter = array();
        if(!empty($country)){
            $sql.=" AND (location_country_code = :countryCODE:)";
            $arrParameter['countryCODE'] = $country;
            $this->dispatcher->setParam("country", $country);
        }
        if(!empty($lang_code)){
            $sql.=" AND (location_lang_code = :langCODE:)";
            $arrParameter['langCODE'] = $lang_code;
            $this->dispatcher->setParam("lang_code", $lang_code);
        }
        if(!empty($active)){
            $sql.=" AND (location_active = :active:)";
            $arrParameter['active'] = $active;
            $this->dispatcher->setParam("active", $active);
        }
        $sql.=" ORDER BY c.country_name ASC,location_order ASC";
        $list_location = $this->modelsManager->executeQuery($sql,$arrParameter);
        $paginator = new PaginatorModel(array(
            'data'  => $list_location,
            'limit' => 1000,
            'page'  => $current_page,
        ));
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
            $this->view->msg_result = $msg_result;
        }
        if ($this->session->has('msg_del')) {
            $msg_result = $this->session->get('msg_del');
            $this->session->remove('msg_del');
            $this->view->msg_del = $msg_result;
        }
        $country_combobox = Location::getCountryGlobalComboBox(strtoupper($country));
        $lang_combobox = Language::getCombo($lang_code);

        $list_link_active_n = VisaLocation::find(array(
            "location_lang_code = 'en' 
            AND location_active = 'N' "
        ));
        //
        $this->view->list_link_active_n = $list_link_active_n;
        $this->view->slCountry          = $country_combobox;
        $this->view->slLanguage         = $lang_combobox;
        $this->view->list_location      = $paginator->getPaginate();
    }

    public function createAction()
    {
        $data = array('location_id' => -1,'location_active' => 'Y', 'location_is_public' => 'N', 'location_is_temp' => 'N',
            'location_order' =>1,'location_country_code' =>'' );
        if($this->request->isPost()) {
            $messages = array();
            $data = array(
                'location_country_code' => strtolower($this->request->getPost("slcCountry", array('string', 'trim'))),
                'location_lang_code' => $this->request->getPost("slcLanguage", array('string', 'trim')),
                'location_alternate_hreflang' => trim($this->request->getPost('txtAlternateHrefLang')),
                'location_schema_contactpoint' => trim($this->request->getPost('txtSchemaContactpoint')),
                'location_schema_social' => trim($this->request->getPost('txtSchemaSocial')),
                'location_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'location_active' => $this->request->getPost("radActive"),
             );
            if (empty($data["location_country_code"])) {
                $messages["country"] = "Country field is required.";
            }
            if (empty($data["location_lang_code"])) {
                $messages["language"] = "Language field is required.";
            }
            if (!empty($data['location_country_code']) && !empty($data['location_lang_code'])){
                if(Location::checkCode($data["location_country_code"],$data["location_lang_code"],-1)){
                    $messages["language"] = "Language is exists";
                }
            }
            if (empty($data['location_order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["location_order"])) {
                $messages["order"] = "Order is not valid ";
            }
            if (count($messages) == 0) {
                $msg_result = array();
                $new_location = new VisaLocation();
                $result = $new_location->save($data);
                if ($result === true) {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Location Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($new_location->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/location");
            }
        }
        $select_country = CountryGeneral::getComboboxByCode(strtoupper($data['location_country_code']));
        $messages["status"] = "border-red";
        $this->view->setVars([
            'formData' => $data,
            'messages' => $messages,
            'select_country' => $select_country,
        ]);
    }

    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function editAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if(!$checkID->validInt($id))
        {
            return $this->response->redirect('notfound');
        }
        $location_model = Location::findFirstById($id);
        if(empty($location_model))
        {
            return $this->response->redirect('notfound');
        }
        $data = $location_model->toArray();
        $messages = array();
        if($this->request->isPost()) {
            $data = array(
                'location_id' => $id,
                'location_country_code' => strtolower($this->request->getPost("slcCountry", array('string', 'trim'))),
                'location_lang_code' => $this->request->getPost("slcLanguage", array('string', 'trim')),
                'location_alternate_hreflang' => trim($this->request->getPost('txtAlternateHrefLang')),
                'location_schema_contactpoint' => trim($this->request->getPost('txtSchemaContactpoint')),
                'location_schema_social' => trim($this->request->getPost('txtSchemaSocial')),
                'location_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'location_active' => $this->request->getPost("radActive"),
             );
            if (empty($data["location_country_code"])) {
                $messages["country"] = "Country field is required.";
            }
            if (empty($data["location_lang_code"])) {
                $messages["language"] = "Language field is required.";
            }
            if (!empty($data['location_country_code']) && !empty($data['location_lang_code'])){
                if(Location::checkCode($data["location_country_code"],$data["location_lang_code"],$id)){
                    $messages["language"] = "Language is exists";
                }
            }
            if (empty($data['location_order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["location_order"])) {
                $messages["order"] = "Order is not valid ";
            }
            if (count($messages) == 0) {
                $msg_result = array();
                $result = $location_model->update($data);
                if ($result === true) {
                    $msg_result = array('status' => 'success', 'msg' => 'Edit location Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($location_model->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/location");
            }
        }
        $select_country = CountryGeneral::getComboboxByCode(strtoupper($data['location_country_code']));
        $messages["status"] = "border-red";
        $this->view->setVars([
            'formData' => $data,
            'messages' => $messages,
            'select_country' => $select_country,
        ]);
    }

    public function deleteAction()
    {
        $location_checked = $this->request->getPost("item");
        var_dump($location_checked);
        if (!empty($location_checked)) {
            $total = 0;
            foreach ($location_checked as $id) {
                $location_item = Location::findFirstById($id);
                if ($location_item) {
                    $msg_result = array();
                    if ($location_item->delete() === false) {
                        $message_delete = 'Can\'t delete the Location ID = '.$location_item->getLocationId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $total++;
                    }
                }
            }
            if($total > 0) {
                $message_delete = 'Delete '. $total .' Location successfully.';
                $message_delete .= '<br>Delete Cache Location + Language Success';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;               ;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect("/location");
        }
    }
    public function getlangbycodeAction(){
        $this->view->disable();
        $countryCode = $this->request->getPost('country_code', array('string', 'trim'));
        $langCode = $this->request->getPost('lang_code', array('string', 'trim'));
        if ($countryCode == 'all') {
            $select_lang = Location::getComboboxLanguage($langCode);
            $string_json = array("string_json" => $select_lang);
            die(json_encode($string_json));
        }
        if (!empty($countryCode)) {
            $select_lang = Location::getComboLocationLangByCode(strtolower($countryCode), $langCode);
            $string_json = array("string_json" => $select_lang);
            die(json_encode($string_json));
        }
    }
    public function getlocationtobylocationfromAction()
    {
        $this->view->disable();
        $location_id = $this->request->getPost('location_from_id', array('string', 'trim'));
        $select_location = "<option value=''>Select Location</option>";
        if ($location_id) {
            $select_location .= Location:: getComboboxByLocationId(0,$location_id);
        }
        die(json_encode($select_location));
    }
}
