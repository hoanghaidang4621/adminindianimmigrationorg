<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaGroupApplicant;
use Indianimmigrationorg\Models\VisaGroupApplicantLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\GroupApplicant;
use Indianimmigrationorg\Repositories\GroupApplicantLang;
use Indianimmigrationorg\Utils\Validator;
class GroupapplicantController extends ControllerBase
{
    public function indexAction()
    {
        $list_group = $this->getParameter();
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $paginator = new PaginatorModel(
            array(
                'data' => $list_group,
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
        $data = array('group_id' => -1, 'group_active' => 'Y','group_order' => 1);
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'group_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'group_value' => $this->request->getPost("txtValue", array('string', 'trim')),
                'group_active' => $this->request->getPost("radActive"),
                'group_order' => $this->request->getPost("txtOrder", array('string', 'trim')),

            );

            if (empty($data['group_name'])) {
                $messages['group_name'] = "Name field is required.";
            }
            if (empty($data["group_value"])) {
                $messages["group_value"] = "Value field is required.";
            } elseif (!is_numeric($data['group_value'])) {
                $messages["group_value"] = "Value  is number.";
            }
            if (empty($data["group_order"])) {
                $messages["group_order"] = "Order field is required.";
            } elseif (!is_numeric($data['group_order'])) {
                $messages["group_order"] = "Order  is number.";
            }
            if (count($messages) == 0) {
                $new_group = new VisaGroupApplicant();
                $message = "We can't store your info now:" . "<br/>";
                if ($new_group->save($data)) {
                    $message = 'Create the Group Apllicant ID: ' . $new_group->getGroupId() . ' success.';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    foreach ($new_group->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result = array('status' => 'error', 'msg' => $message);
                }
                $this->session->set('msg_result', $msg_result);
                $this->response->redirect("/groupapplicant");
                return;
            }
        }
        $messages["status"] = "border-red";
        $data['mode'] = 'create';
        $this->view->setVars(array(
            'title' => 'Create Group Applicant',
            'formData' => $data,
            'messages' => $messages,
        ));
    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $group_model = GroupApplicant::findFirstById($id);
        if(empty($group_model))
        {
            return $this->response->redirect('notfound');
        }
        $data_post = $group_model->toArray();
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
                $data_post['group_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                if (empty($data_post['group_name'])) {
                    $messages[$save_mode]['group_name'] = 'Name field is required.';
                }
            } else {
                $data_post['group_value'] =  $this->request->getPost("txtValue", array('string', 'trim'));
                $data_post['group_active'] =  $this->request->getPost("radActive", array('string', 'trim'));
                $data_post['group_order'] =  $this->request->getPost("txtOrder", array('string', 'trim'));
                if (empty($data_post["group_value"])) {
                    $messages["group_value"] = "Value field is required.";
                } elseif (!is_numeric($data_post['group_value'])) {
                    $messages["group_value"] = "Value  is number.";
                }
                if (empty($data_post["group_order"])) {
                    $messages["group_order"] = "Order field is required.";
                } elseif (!is_numeric($data_post['group_order'])) {
                    $messages["group_order"] = "Order  is number.";
                }

            }
            if(empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $group_model->update($data_post);
                        $info = VisaLanguage::GENERAL;

                        break;
                    case $this->globalVariable->defaultLanguage :
                        $group_model->setGroupName($data_post['group_name']);
                        $result = $group_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $group_lang_model = GroupApplicantLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$group_lang_model) {
                            $group_lang_model = new VisaGroupApplicantLang();
                            $group_lang_model->setGroupId($id);
                            $group_lang_model->setGroupLangCode($save_mode);
                        }
                        $group_lang_model->setGroupName($data_post['group_name']);
                        $result = $group_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Group Applicant success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Group Applicantfail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'group_id' =>$group_model->getGroupId(),
            'group_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['group_name']:$group_model->getGroupName(),
        );
        $arr_translate[$lang_default] = $item;
        $arr_group_lang = GroupApplicantLang::findById($id);
        foreach ($arr_group_lang as $group_lang){
            $item = array(
                'group_id'=>$group_lang->getGroupId(),
                'group_name'=>($save_mode === $group_lang->getGroupLangCode())?$data_post['group_name']:$group_lang->getGroupName(),
            );
            $arr_translate[$group_lang->getGroupLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'group_id'=> -1,
                'group_name'=> $data_post['group_name'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'group_id'=>$group_model->getGroupId(),
            'group_value' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['group_value']:$group_model->getGroupValue(),
            'group_active' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['group_active']:$group_model->getGroupActive(),
            'group_order' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['group_order']:$group_model->getGroupOrder(),
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
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaGroupApplicant AS m WHERE 1 ";
        if (!empty($keyword)) {
            $sql .= " AND m.group_id  = :keyword: OR m.group_name like CONCAT('%',:keyword:,'%') ";
            $arrParameter['keyword'] = $keyword;
            $this->dispatcher->setParam("txtSearch", $keyword);
        }

        $sql .= " ORDER BY m.group_id DESC";
        return $this->modelsManager->executeQuery($sql, $arrParameter);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                $item = GroupApplicant::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Group Applicant ID = ' . $item->getGroupId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        GroupApplicantLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' Group Applicant successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/groupapplicant');
    }

}