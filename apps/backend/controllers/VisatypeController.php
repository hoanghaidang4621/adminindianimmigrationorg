<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaVisaType;
use Indianimmigrationorg\Models\VisaVisaTypeLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\VisaType;
use Indianimmigrationorg\Repositories\VisaTypeLang;
use Indianimmigrationorg\Utils\Validator;
class VisatypeController extends ControllerBase
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
                'type_group_name' => $this->request->getPost("txtGroupName", array('string', 'trim')),
                'type_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'type_icon' => $this->request->getPost("txtIcon", array('string', 'trim')),
                'type_active' => $this->request->getPost("radActive"),
                'type_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'type_description' => trim($this->request->getPost("txtDescription")),
                'type_ineligible_content' => trim($this->request->getPost("txtIneligibleContent")),
                'type_required_content' => trim($this->request->getPost("txtRequiredContent")),
                'type_document_requirement' => trim($this->request->getPost("txtDocumentRequirement")),
            );
            if (empty($data['type_group_name'])) {
                $messages['type_group_name'] = "Group Type field is required.";
            }
            if (empty($data['type_name'])) {
                $messages['type_name'] = "Name field is required.";
            }
            if (empty($data["type_order"])) {
                $messages["type_order"] = "Order field is required.";
            } elseif (!is_numeric($data['type_order'])) {
                $messages["type_order"] = "Order  is number.";
            }
            if (empty($data['type_description'])) {
                $messages['type_description'] = "Description field is required.";
            }
            if (count($messages) == 0) {
                $new_type = new VisaVisaType();
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
                $this->response->redirect("/visatype");
                return;
            }
        }
        $messages["status"] = "border-red";
        $data['mode'] = 'create';
        $this->view->setVars(array(
            'title' => 'Create Visa Type',
            'formData' => $data,
            'messages' => $messages,
        ));
    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $type_model = VisaType::findFirstById($id);
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
                $data_post['type_group_name'] = $this->request->getPost("txtGroupName", array('string', 'trim'));
                $data_post['type_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                $data_post['type_description'] = trim($this->request->get("txtDescription"));
                $data_post['type_ineligible_content'] = trim($this->request->getPost("txtIneligibleContent"));
                $data_post['type_required_content'] = trim($this->request->getPost("txtRequiredContent"));
                $data_post['type_document_requirement'] = trim($this->request->getPost("txtDocumentRequirement"));
                if (empty($data_post['type_group_name'])) {
                    $messages[$save_mode]['type_name'] = 'Group Name field is required.';
                }
                if (empty($data_post['type_name'])) {
                    $messages[$save_mode]['type_name'] = 'Name field is required.';
                }
                if (empty($data_post['type_description'])) {
                    $messages[$save_mode]['type_description'] = 'Description field is required.';
                }
            } else {
                $data_post['type_icon'] =  $this->request->getPost("txtIcon", array('string', 'trim'));
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
                        $result = $type_model->update($data_post);
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $type_lang_model = VisaTypeLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$type_lang_model) {
                            $type_lang_model = new VisaVisaTypeLang();
                            $type_lang_model->setTypeId($id);
                            $type_lang_model->setTypeLangCode($save_mode);
                        }
                        $type_lang_model->setTypeGroupName($data_post['type_group_name']);
                        $type_lang_model->setTypeName($data_post['type_name']);
                        $type_lang_model->setTypeDescription($data_post['type_description']);
                        $type_lang_model->setTypeIneligibleContent($data_post['type_ineligible_content']);
                        $type_lang_model->setTypeRequiredContent($data_post['type_required_content']);
                        $type_lang_model->setTypeDocumentRequirement($data_post['type_document_requirement']);
                        $result = $type_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Visa Type success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Visa Type fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'type_id' =>$type_model->getTypeId(),
            'type_group_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_group_name']:$type_model->getTypeGroupName(),
            'type_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_name']:$type_model->getTypeName(),
            'type_description'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_description']:$type_model->getTypeDescription(),
            'type_ineligible_content'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_ineligible_content']:$type_model->getTypeIneligibleContent(),
            'type_required_content'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_required_content']:$type_model->getTypeRequiredContent(),
            'type_document_requirement'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['type_document_requirement']:$type_model->getTypeDocumentRequirement(),
        );
        $arr_translate[$lang_default] = $item;
        $arr_type_lang = VisaTypeLang::findById($id);
        foreach ($arr_type_lang as $type_lang){
            $item = array(
                'type_id'=>$type_lang->getTypeId(),
                'type_group_name'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_group_name']:$type_lang->getTypeGroupName(),
                'type_name'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_name']:$type_lang->getTypeName(),
                'type_description'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_description']:$type_lang->getTypeDescription(),
                'type_ineligible_content'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_ineligible_content']:$type_lang->getTypeIneligibleContent(),
                'type_required_content'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_required_content']:$type_lang->getTypeRequiredContent(),
                'type_document_requirement'=>($save_mode === $type_lang->getTypeLangCode())?$data_post['type_document_requirement']:$type_lang->getTypeDocumentRequirement(),
            );
            $arr_translate[$type_lang->getTypeLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'type_id'=> -1,
                'type_group_name'=> $data_post['type_group_name'],
                'type_name'=> $data_post['type_name'],
                'type_description'  => $data_post['type_description'],
                'type_ineligible_content'   => $data_post['type_ineligible_content'],
                'type_required_content'=>   $data_post['type_required_content'],
                'type_document_requirement'=>$data_post['type_document_requirement'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'type_id'=>$type_model->getTypeId(),
            'type_icon' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['type_icon']:$type_model->getTypeIcon(),
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
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaVisaType AS m WHERE 1 ";
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
                $item = VisaType::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Visa Type ID = ' . $item->getTypeId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        VisaTypeLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' Visa Type successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/visatype');
    }

}