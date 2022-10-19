<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaPortType;
use Indianimmigrationorg\Models\VisaPortTypeLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\PortType;
use Indianimmigrationorg\Repositories\PortTypeLang;
use Indianimmigrationorg\Utils\Validator;
class PorttypeController extends ControllerBase
{
    public function indexAction()
    {
        $list_type = $this->getParameter();
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $paginator = new PaginatorModel(
            array(
                'data' => $list_type,
                'limit' => 20,
                'page' => $current_page,
            )
        );
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
        $this->view->setVars(array(
            'list_data' => $paginator->getPaginate(),
            'msg_result' => $msg_result,
            'msg_delete' => $msg_delete,
        ));
    }

    public function createAction()
    {
        $data = array('type_id' => -1, 'type_active' => 'Y','type_order' => 1);
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'type_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'type_active' => $this->request->getPost("radActive"),
                'type_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
            );

            if (empty($data['type_name'])) {
                $messages['type_name'] = "Name field is required.";
            }
            if (empty($data["type_order"])) {
                $messages["type_order"] = "Order field is required.";
            } elseif (!is_numeric($data['type_order'])) {
                $messages["type_order"] = "Order  is number.";
            }
            if (count($messages) == 0) {
                $new_type = new VisaPortType();
                $message = "We can't store your info now:" . "<br/>";
                if ($new_type->save($data)) {
                    $message = 'Create the Type ID: ' . $new_type->getTypeId() . ' success.';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    foreach ($new_type->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result = array('status' => 'error', 'msg' => $message);
                }
                $this->session->set('msg_result', $msg_result);
                $this->response->redirect("/porttype");
                return;
            }
        }
        $messages["status"] = "border-red";
        $data['mode'] = 'create';
        $this->view->setVars(array(
            'formData' => $data,
            'messages' => $messages,
        ));
    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $type_model = PortType::findFirstById($id);
        if(empty($type_model))
        {
            return $this->response->redirect('notfound');
        }
        $data_post = $type_model->toArray();
        $messages = array();
        $save_mode = '';
        $lang_default = $this->globalVariable->defaultLanguage;
        $lang_current = $lang_default;
        $arr_language = Language::arrLanguages();
        if($this->request->isPost()) {
            if(!isset($_POST['save'])){
                $this->view->disable();
                $this->response->redirect("notfound");
                return;
            }
            $save_mode =  $_POST['save'] ;
            if (isset($arr_language[$save_mode])) {
                $lang_current = $save_mode;
            }
            if($save_mode != VisaLanguage::GENERAL) {
                $data_post['type_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                if (empty($data_post['type_name'])) {
                    $messages[$save_mode]['type_name'] = 'Name field is required.';
                }
            } else {
                $data_post['type_active'] =  $this->request->getPost("radActive", array('string', 'trim'));
                $data_post['type_order'] =  $this->request->getPost("txtOrder", array('string', 'trim'));
                if (empty($data_post["type_order"])) {
                    $messages["type_order"] = "Order field is required.";
                } elseif (!is_numeric($data_post['type_order'])) {
                    $messages["type_order"] = "Order  is number.";
                }

            }
            if(empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $type_model->update($data_post);
                        $info = VisaLanguage::GENERAL;

                        break;
                    case $this->globalVariable->defaultLanguage :
                        $type_model->setTypeName($data_post['type_name']);
                        $result = $type_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $type_lang_model = PortTypeLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$type_lang_model) {
                            $type_lang_model = new VisaPortTypeLang();
                            $type_lang_model->setTypeId($id);
                            $type_lang_model->setTypeLangCode($save_mode);
                        }
                        $type_lang_model->setTypeName($data_post['type_name']);

                        $result = $type_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update PortType success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Port Type fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'type_id' =>$type_model->getTypeId(),
            'type_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_name']:$type_model->getTypeName(),
        );

        $arr_translate[$lang_default] = $item;
        $arr_type_lang = PortTypeLang::findById($id);

        foreach ($arr_type_lang as $type_lang){
            $item = array(
                'type_id'=>$type_lang->getTypeId(),
                'type_name'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_name']:$type_lang->getTypeName(),
            );
            $arr_translate[$type_lang->getTypeLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'type_id'=> -1,
                'type_name'=> $data_post['type_name'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'type_id'=>$type_model->getTypeId(),
            'type_active' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['type_active']:$type_model->getTypeActive(),
            'type_order' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['type_order']:$type_model->getTypeOrder(),
            'arr_translate' => $arr_translate,
            'arr_language' => $arr_language,
            'lang_default' => $lang_default,
            'lang_current' => $lang_current
        );
        $messages['status'] = 'border-red';
        $this->view->setVars([
            'formData' => $formData,
            'messages' => $messages,
        ]);

    }
    private function getParameter()
    {
        $keyword = trim($this->request->get("txtSearch"));
        $arrParameter = [];
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaPortType AS m WHERE 1 ";
        if (!empty($keyword)) {
            $sql .= " AND m.type_id  = :keyword: OR m.type_name like CONCAT('%',:keyword:,'%') ";
            $arrParameter['keyword'] = $keyword;
            $this->dispatcher->setParam("txtSearch", $keyword);
        }

        $sql .= " ORDER BY m.type_id DESC";
        return $this->modelsManager->executeQuery($sql, $arrParameter);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                $item = PortType::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Port Type ID = ' . $item->getTypeId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        PortTypeLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' Port Type successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/porttype');
    }

}