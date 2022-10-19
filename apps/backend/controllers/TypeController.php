<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaType;
use Indianimmigrationorg\Models\VisaTypeLang;
use Indianimmigrationorg\Repositories\Article;
use Indianimmigrationorg\Repositories\Country;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\Location;
use Indianimmigrationorg\Repositories\Type;
use Indianimmigrationorg\Repositories\TypeLang;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\NativeArray;

class TypeController extends ControllerBase
{
    protected $global_location_country_code;

    public function initialize()
    {
        $this->global_location_country_code = strtoupper($this->globalVariable->global['code']);
        parent::initialize();
    }

    public function indexAction()
    {
        $selectAll = '';
        $location_country_code = trim($this->request->get("slcLocationCountry"));
        $keyword = trim($this->request->get("txtSearch"));
        if ($location_country_code == 'all' && (substr_count(trim($keyword), ' ') > 0 || strlen(trim($keyword)) > 1)) {
            $selectAll = "OR t.type_location_country_code != ''";
        }
        if (empty($location_country_code)) {
            $location_country_code = strtoupper($this->globalVariable->global['code']);
        }

        $data = $this->getParameter($location_country_code, $selectAll);
        $list_type = $this->modelsManager->executeQuery($data['sql'], $data['para']);
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $msg_delete = array();
        if ($this->session->has('msg_delete')) {
            $msg_delete = $this->session->get('msg_delete');
            $this->session->remove('msg_delete');
        }
        $lang_search = isset($data["para"]["lang_code"]) ? $data["para"]["lang_code"] : $this->globalVariable->defaultLanguage;
        $result = array();
        if ($list_type && sizeof($list_type) > 0) {
            if ($lang_search != $this->globalVariable->defaultLanguage) {
                foreach ($list_type as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(
                        new VisaType(), array_merge($item->t->toArray(), $item->tl->toArray()));
                }
            } else {
                foreach ($list_type as $item) {
                    $result[] = \Phalcon\Mvc\Model::cloneResult(new VisaType(), $item->toArray());
                }
            }
        }
        $paginator = new NativeArray(
            [
                'data' => $result,
                'limit' => 20,
                'page' => $current_page,
            ]
        );
        $select_location_country = Location::getCountryGlobalComboBox($location_country_code);

        $type = new Type();
        $type_search = isset($data["para"]["type_id"]) ? $data["para"]["type_id"] : 0;
        $select_type = $type->getParentIdType("", 0, $type_search);
        $this->view->setVars(array(
            'page' => $paginator->getPaginate(),
            'msg_result' => $msg_result,
            'msg_delete' => $msg_delete,
            'select_location_country' => $select_location_country,
            'location_country_code' => $location_country_code,
            'select_type' => $select_type,
        ));
        $replace = trim($this->request->get("txtReplace"));
        $this->dispatcher->setParam("txtReplace", $replace);
        $total_success = 0;
        $check_btnreplace = $this->request->get("checkbtnReplace");
        if ($check_btnreplace === 'TRUE') {
            $checkReplace = $this->dispatcher->getParam('checkReplace');
            if (empty($checkReplace)) {
                $tn_log = array();
                $tn_log['find'] = $keyword;
                $tn_log['replace'] = $replace;
                $tn_log['data'] = array();
                if ($lang_search == $this->globalVariable->defaultLanguage) {
                    foreach ($list_type as $item) {

                        $t = 0;
                        $change_field = array();

                        $temp = str_replace($keyword, $replace, $item->getTypeName());
                        if ($temp != $item->getTypeName()) {
                            $t++;
                            $item->setTypeName($temp);
                            array_push($change_field, 'type_name');
                        }

                        $temp = str_replace($keyword, $replace, $item->getTypeTitle());
                        if ($temp != $item->getTypeTitle()) {
                            $t++;
                            $item->setTypeTitle($temp);
                            array_push($change_field, 'type_title');
                        }

                        $temp = str_replace($keyword, $replace, $item->getTypeMetaKeyword());
                        if ($temp != $item->getTypeMetaKeyword()) {
                            $t++;
                            $item->setTypeMetaKeyword($temp);
                            array_push($change_field, 'type_meta_keyword');
                        }

                        $temp = str_replace($keyword, $replace, $item->getTypeMetaDescription());
                        if ($temp != $item->getTypeMetaDescription()) {
                            $t++;
                            $item->setTypeMetaDescription($temp);
                            array_push($change_field, 'type_meta_description');
                        }

                        $res = false;
                        if ($t > 0) {
                            $res = $item->update();
                        }
                        if ($res) {
                            $total_success++;
                            $key_log = 'id: ' . $item->getTypeId() . ', location_country_code: ' . $item->getTypeLocationCountryCode();
                            $data = array(
                                'key' => $key_log,
                                'change' => (count($change_field) > 0) ? implode($change_field, ', ') : '',
                            );
                            array_push($tn_log['data'], $data);
                        }
                    }
                } else {
                    foreach ($list_type as $item) {

                        $t = 0;
                        $change_field = array();

                        $temp = str_replace($keyword, $replace, $item->tl->getTypeName());
                        if ($temp != $item->tl->getTypeName()) {
                            $t++;
                            $item->tl->setTypeName($temp);
                            array_push($change_field, 'type_name');
                        }

                        $temp = str_replace($keyword, $replace, $item->tl->getTypeTitle());
                        if ($temp != $item->tl->getTypeTitle()) {
                            $t++;
                            $item->tl->setTypeTitle($temp);
                            array_push($change_field, 'type_title');
                        }

                        $temp = str_replace($keyword, $replace, $item->tl->getTypeMetaKeyword());
                        if ($temp != $item->tl->getTypeMetaKeyword()) {
                            $t++;
                            $item->tl->setTypeMetaKeyword($temp);
                            array_push($change_field, 'type_meta_keyword');
                        }

                        $temp = str_replace($keyword, $replace, $item->tl->getTypeMetaDescription());
                        if ($temp != $item->tl->getTypeMetaDescription()) {
                            $t++;
                            $item->tl->setTypeMetaDescription($temp);
                            array_push($change_field, 'type_meta_description');
                        }

                        $res = false;
                        if ($t > 0) {
                            $res = $item->tl->update();
                        }
                        if ($res) {
                            $total_success++;
                            $key_log = 'id: ' . $item->tl->getTypeId() . ', lang_code: ' . $item->tl->getTypeLangCode() . ', location_country_code: ' . $item->tl->getTypeLocationCountryCode();
                            $data = array(
                                'key' => $key_log,
                                'change' => (count($change_field) > 0) ? implode($change_field, ', ') : '',
                            );
                            array_push($tn_log['data'], $data);
                        }
                    }
                }

                $msg_result = array();
                $msg_result['status'] = 'success';
                $msg_result['msg'] = 'Replace success: ' . $total_success . '.';
                $this->session->set('msg_result', $msg_result);
                return $this->dispatcher->forward(array(
                    'controller' => $this->dispatcher->getControllerName(),
                    'action' => $this->dispatcher->getActionName(),
                    'params' => array(
                        'checkReplace' => TRUE,
                    )
                ));
            }
        }
    }

    public function createAction()
    {
        $data = array('id' => -1, 'order' => 1, 'active' => 'Y','type_parent_id' => 0);
        $messages = array();
        $location_country_code = $this->globalVariable->defaultLocation;
        if ($this->request->isPost()) {
            $messages = array();
            $data = array(
                'id' => -1,
                'type_parent_id' => $this->request->getPost("slcParent"),
                'name' => trim($this->request->getPost("txtName")),
                'title' => $this->request->getPost("txtTitle", array('string', 'trim')),
                'keyword' => $this->request->getPost("txtKeyword", array('string', 'trim')),
                'meta_description' => $this->request->getPost("txtMetades", array('string', 'trim')),
                'meta_keyword' => $this->request->getPost("txtMetakey", array('string', 'trim')),
                'meta_image' => $this->request->getPost("txtMetaImage", array('string', 'trim')),
                'order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'active' => $this->request->getPost("radActive"),
            );

            if (empty($data["name"])) {
                $messages["name"] = "Name field is required.";
            }
            if (empty($data["title"])) {
                $messages["title"] = "Title field is required.";
            }
            if (empty($data["keyword"])) {
                $messages["keyword"] = "Keyword field is required.";
            }

            if (empty($data["meta_description"])) {
                $messages["meta_description"] = "Meta description field is required.";
            }
            if (empty($data["meta_keyword"])) {
                $messages["meta_keyword"] = "Meta keyword field is required.";
            }
            if (empty($data['order'])) {
                $messages['order'] = "Order field is required.";
            } else if (!is_numeric($data['order'])) {
                $messages['order'] = "Order is not valid";
            }

            if (count($messages) == 0) {
                $msg_result = array();
                $new_page = new VisaType();
                $new_page->setTypeParentId($data["type_parent_id"]);
                $new_page->setTypeName($data["name"]);
                $new_page->setTypeTitle($data["title"]);
                $new_page->setTypeKeyword($data["keyword"]);
                $new_page->setTypeMetaDescription($data["meta_description"]);
                $new_page->setTypeMetaImage($data["meta_image"]);
                $new_page->setTypeMetaKeyword($data["meta_keyword"]);
                $new_page->setTypeOrder($data["order"]);
                $new_page->setTypeActive($data["active"]);
                $new_page->setTypeLocationCountryCode($location_country_code);
                $result = $new_page->save();

                if ($result === true) {
                    $message = 'Create the type ID: ' . $new_page->getTypeId() . ' success';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    $message = "We can't store your info now: <br/>";
                    foreach ($new_page->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/type");
            }
        }

        $select_type = Type::getParentIdType("", 0, $data["type_parent_id"]);
        $messages["status"] = "border-red";
        $this->view->setVars([
            'oldinput' => $data,
            'messages' => $messages,
            'select_type' => $select_type,
        ]);
    }

    public function editAction()
    {
        $type_id = $this->request->get('id');
        $location_country_code = $this->request->get('slcLocationCountry');
        $lang_current = $this->request->get('slcLang');
        if ($location_country_code != strtoupper($this->globalVariable->global['code'])) {
            $country_model = CountryGeneral::findByCode($location_country_code);
            if (empty($country_model)) {
                return $this->response->redirect('notfound');
            }
        }
        $checkID = new Validator();
        if (!$checkID->validInt($type_id)) {
            $this->response->redirect('notfound');
            return;
        }
        $type_model = Type::findFirstByIdAndLocationCountryCode($type_id, $location_country_code);
        if (empty($type_model)) {
            $this->response->redirect('notfound');
            return;
        }
        $arr_translate = array();
        $messages = array();
        $data_post = array(
            'type_id ' => -1,
            'type_active' => '',
            'type_name' => '',
            'type_title' => '',
            'type_keyword ' => '',
            'type_meta_keyword' => '',
            'type_meta_description' => '',
            'type_meta_image' => '',
            'type_parent_id' => '',
            'type_order' => '',
            'type_location_country_code' => $location_country_code,
        );
        $save_mode = '';
        $arr_language = Location::arrLanguages($location_country_code);
        if ($this->request->isPost()) {
            if (!isset($_POST['save'])) {
                $this->view->disable();
                $this->response->redirect("notfound");
                return;
            }
            $save_mode = $_POST['save'];
            if (isset($arr_language[$save_mode])) {
                $lang_current = $save_mode;
            }
            if ($save_mode != VisaLanguage::GENERAL) {
                $data_post['type_name'] = $this->request->getPost('txtName', array('string', 'trim'));
                $data_post['type_keyword'] = $this->request->getPost('txtKeyword', array('string', 'trim'));
                $data_post['type_title'] = $this->request->getPost('txtTitle', array('string', 'trim'));
                $data_post['type_meta_keyword'] = $this->request->getPost('txtMetaKey', array('string', 'trim'));
                $data_post['type_meta_description'] = $this->request->getPost('txtMetaDesc', array('string', 'trim'));
                if (empty($data_post['type_name'])) {
                    $messages[$save_mode]['name'] = 'Name field is required.';
                }
                if (empty($data_post['type_keyword'])) {
                    $messages[$save_mode]['keyword'] = 'Keyword field is required.';
                }
                if (empty($data_post['type_title'])) {
                    $messages[$save_mode]['title'] = 'Title field is required.';
                }
                if (empty($data_post['type_meta_keyword'])) {
                    $messages[$save_mode]['meta_keyword'] = 'Meta keyword field is required.';
                }
                if (empty($data_post['type_meta_description'])) {
                    $messages[$save_mode]['meta_description'] = 'Meta description field is required.';
                }
            } else {
                $data_post['type_parent_id'] = $this->request->getPost('slcParent');
                $data_post['type_order'] = $this->request->getPost('txtOrder', array('string', 'trim'));
                $data_post['type_meta_image'] = $this->request->getPost('txtMetaImage', array('string', 'trim'));
                $data_post['type_active'] = $this->request->getPost("radActive");
                if (empty($data_post['type_order'])) {
                    $messages['order'] = "Order field is required.";
                } else if (!is_numeric($data_post['type_order'])) {
                    $messages['order'] = "Order is not valid.";
                }
            }
            if (empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $type_model->setTypeMetaImage($data_post['type_meta_image']);
                        $type_model->setTypeOrder($data_post['type_order']);
                        $type_model->setTypeParentId($data_post['type_parent_id']);
                        $type_model->setTypeActive($data_post['type_active']);
                        $result = $type_model->update();
                        $info = VisaLanguage::GENERAL;
                        break;
                    case $this->globalVariable->defaultLanguage :
                        $type_model->setTypeName($data_post['type_name']);
                        $type_model->setTypeKeyword($data_post['type_keyword']);
                        $type_model->setTypeTitle($data_post['type_title']);
                        $type_model->setTypeMetaKeyword($data_post['type_meta_keyword']);
                        $type_model->setTypeMetaDescription($data_post['type_meta_description']);
                        $result = $type_model->update();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $type_lang_model = TypeLang::findFirstByIdAndLocationCountryCodeAndLang($type_id, $location_country_code, $save_mode);
                        if (!$type_lang_model) {
                            $type_lang_model = new VisaTypeLang();
                            $type_lang_model->setTypeId($type_id);
                            $type_lang_model->setTypeLangCode($save_mode);
                            $type_lang_model->setTypeLocationCountryCode(strtolower($location_country_code));
                        }
                        $type_lang_model->setTypeName($data_post['type_name']);
                        $type_lang_model->setTypeKeyword($data_post['type_keyword']);
                        $type_lang_model->setTypeTitle($data_post['type_title']);
                        $type_lang_model->setTypeMetaKeyword($data_post['type_meta_keyword']);
                        $type_lang_model->setTypeMetaDescription($data_post['type_meta_description']);
                        $result = $type_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update type success"),
                        'typeMessage' => "success",
                    );
                } else {
                    $messages = array(
                        'message' => "Update type fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $type_model = Type::findFirstByIdAndLocationCountryCode($type_model->getTypeId(), $type_model->getTypeLocationCountryCode());
        $item = array(
            'type_id' => $type_model->getTypeId(),
            'type_name' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['type_name'] : $type_model->getTypeName(),
            'type_keyword' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['type_keyword'] : $type_model->getTypeKeyword(),
            'type_title' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['type_title'] : $type_model->getTypeTitle(),
            'type_meta_keyword' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['type_meta_keyword'] : $type_model->getTypeMetaKeyword(),
            'type_meta_description' => ($save_mode === $this->globalVariable->defaultLanguage) ? $data_post['type_meta_description'] : $type_model->getTypeMetaDescription(),
        );
        $arr_translate[$this->globalVariable->defaultLanguage] = $item;
        $arr_type_lang = TypeLang::findByIdAndLocationCountryCode($type_id, $location_country_code);
        foreach ($arr_type_lang as $type_lang) {
            $item = array(
                'type_id' => $type_lang->getTypeId(),
                'type_name' => ($save_mode === $type_lang->getTypeLangCode()) ? $data_post['type_name'] : $type_lang->getTypeName(),
                'type_keyword' => ($save_mode === $type_lang->getTypeLangCode()) ? $data_post['type_meta_keyword'] : $type_lang->getTypeKeyword(),
                'type_title' => ($save_mode === $type_lang->getTypeLangCode()) ? $data_post['type_title'] : $type_lang->getTypeTitle(),
                'type_meta_keyword' => ($save_mode === $type_lang->getTypeLangCode()) ? $data_post['type_meta_keyword'] : $type_lang->getTypeMetaKeyword(),
                'type_meta_description' => ($save_mode === $type_lang->getTypeLangCode()) ? $data_post['type_meta_description'] : $type_lang->getTypeMetaDescription(),
            );
            $arr_translate[$type_lang->getTypeLangCode()] = $item;
        }
        if (!isset($arr_translate[$save_mode]) && isset($arr_language[$save_mode])) {
            $item = array(
                'type_id' => -1,
                'type_name' => $data_post['type_name'],
                'type_keyword' => $data_post['type_keyword'],
                'type_title' => $data_post['type_title'],
                'type_meta_keyword' => $data_post['type_meta_keyword'],
                'type_meta_description' => $data_post['type_meta_description'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'type_id' => $type_model->getTypeId(),
            'type_location_country_code' => $type_model->getTypeLocationCountryCode(),
            'type_parent_id' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['type_parent_id'] : $type_model->getTypeParentId(),
            'type_order' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['type_order'] : $type_model->getTypeOrder(),
            'type_meta_image' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['type_meta_image'] : $type_model->getTypeMetaImage(),
            'type_active' => ($save_mode === VisaLanguage::GENERAL) ? $data_post['type_active'] : $type_model->getTypeActive(),
            'arr_translate' => $arr_translate,
            'arr_language' => $arr_language,
            'lang_current' => $lang_current
        );
        $messages["status"] = "border-red";
        $select_type = Type::getParentIdType("", 0, $formData["type_parent_id"]);
        $select_location_country = Location::getCountryGlobalComboBox($location_country_code);
        $this->view->setVars([
            'formData' => $formData,
            'messages' => $messages,
            'select_type' => $select_type,
            'location_country_code' => $location_country_code,
            'select_location_country' => $select_location_country,
        ]);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        $location_country_code = $this->request->get('slcLocationCountry');
        $lang = $this->request->get("slcLang");

        if ($location_country_code == '') {
            return $this->response->redirect("notfound");
        }

        if ($location_country_code != $this->global_location_country_code) {
            $country_model = CountryGeneral::findByCode($location_country_code);
            if (empty($country_model)) {
                return $this->response->redirect("notfound");
            }
        }
        if (($location_country_code != $this->global_location_country_code)||($lang != $this->globalVariable->defaultLanguage)) {
            return $this->response->redirect("notfound");
        }
        $msg_delete =[];
        if (!empty($items_checked)) {
            $msg_result = array();
            $total = 0;
            foreach ($items_checked as $id) {
                if ($lang != $this->globalVariable->defaultLanguage) {
                    $item = TypeLang::findFirstByIdAndLang($id, $lang, $location_country_code);
                } else {
                    $item = Type::findFirstByIdAndLocationCountryCode($id, $location_country_code);
                }
                $table = array();
                if ($item) {
                    if ($location_country_code == $this->global_location_country_code) {
                        $parent = Type::findFirstByParentId($id);
                        if ($parent) $table['child'] = 'Parent Type';
                        $article = Article::findFirstByType($id);
                        if ($article) $table['article'] = 'Article';
                    }
                    if (count($table) > 0) {
                        $message_delete = 'Can\'t delete the Type Name = ' . $item->getTypeName().' Because has item in ' . implode(', ',$table)."<br>";
                        $msg_delete['status'] = 'error';
                        $msg_delete['msg'] .= $message_delete;
                    } else {
                        if ($item->delete() === false) {
                            $message_delete = 'Can\'t delete the Blog Type Name = ' . $item->getTypeName()."<br>";
                            $msg_delete['status'] = 'error';
                            $msg_delete['msg'] .= $message_delete;
                        } else {
                            $total++;
                            if (strtolower($location_country_code) == $this->globalVariable->global['code']) {
                                TypeLang::deleteById($id);
                            }
                            if ($lang == $this->globalVariable->defaultLanguage) {
                                TypeLang::deleteByIdAndLocationCountryCode($id, $location_country_code);
                            }
                        }
                    }
                }
            }
            if ($total > 0) {
                $message_delete = 'Delete ' . $total . ' Type successfully.'."<br>";
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;

            }
            $this->session->set('msg_result', $msg_result);
            $this->session->set('msg_delete', $msg_delete);
            return $this->response->redirect('/type?slcLocationCountry=' . $location_country_code . '&slcLang=' . $lang);
        }
    }

    private function getParameter($location_country_code, $selectAll = '')
    {
        $lang = $this->request->get("slcLang", array('string', 'trim'));
        $type = $this->request->get("slType");
        $keyword = trim($this->request->get("txtSearch"));
        $langCode = !empty($lang) ? $lang : $this->globalVariable->defaultLanguage;
        $this->dispatcher->setParam("slcLang", $langCode);
        $arrParameter = array('location_country_code' => $location_country_code);

        $match = trim($this->request->get("radMatch"));
        if ($match == '') {
            $match = 'notmatch';
        }
        $this->dispatcher->setParam("radMatch", $match);

        $validator = new Validator();
        if ($langCode === $this->globalVariable->defaultLanguage) {
            $sql = "SELECT t.* FROM Indianimmigrationorg\Models\VisaType t WHERE 1";
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND (t.type_id = :number:)";
                    $arrParameter['number'] = $keyword;
                } else {
                    if ($match == 'match') {
                        $sql .= " AND (t.type_name =:keyword: OR t.type_title =:keyword:
                                     OR t.type_meta_keyword =:keyword: OR t.type_meta_description =:keyword:  
                                    )";
                    } else {
                        $sql .= " AND (t.type_name like CONCAT('%',:keyword:,'%') OR t.type_title like CONCAT('%',:keyword:,'%')
                                     OR t.type_meta_keyword like CONCAT('%',:keyword:,'%') OR t.type_meta_description like CONCAT('%',:keyword:,'%')
                                     )";
                    }
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        } else {
            $sql = "SELECT t.*, tl.* FROM Indianimmigrationorg\Models\VisaType t 
                    INNER JOIN \Indianimmigrationorg\Models\VisaTypeLang tl
                                ON tl.type_id = t.type_id AND tl.type_location_country_code = t.type_location_country_code AND  tl.type_lang_code = :lang_code:                           
                    WHERE 1";
            $arrParameter['lang_code'] = $langCode;
            $this->dispatcher->setParam("slcLang", $langCode);
            if (!empty($keyword)) {
                if ($validator->validInt($keyword)) {
                    $sql .= " AND (t.type_id = :number:)";
                    $arrParameter['number'] = $keyword;
                } else {
                    if ($match == 'match') {
                        $sql .= " AND (tl.type_name =:keyword: OR tl.type_title =:keyword:
                                     OR tl.type_meta_keyword =:keyword: OR tl.type_meta_description =:keyword:
                                    )";
                    } else {
                        $sql .= " AND (tl.type_name like CONCAT('%',:keyword:,'%') OR tl.type_title like CONCAT('%',:keyword:,'%')
                                     OR tl.type_meta_keyword like CONCAT('%',:keyword:,'%') OR tl.type_meta_description like CONCAT('%',:keyword:,'%')
                                     )";
                    }
                    $arrParameter['keyword'] = $keyword;
                }
                $this->dispatcher->setParam("txtSearch", $keyword);
            }
        }
        if (!empty($type)) {
            if ($validator->validInt($type) == false) {
                $this->response->redirect("/notfound");
                return;
            }
            $sql .= " AND t.type_parent_id = :type_id:";
            $arrParameter["type_id"] = $type;
            $this->dispatcher->setParam("slType", $type);
        }
        $sql .= " AND (t.type_location_country_code  = :location_country_code:" . $selectAll . ") ORDER BY t.type_id DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }

}