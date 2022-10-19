<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaProcessingFee;
use Indianimmigrationorg\Models\VisaProcessingFeeLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\ProcessingFee;
use Indianimmigrationorg\Repositories\ProcessingFeeLang;
use Indianimmigrationorg\Utils\Validator;

class ProcessingfeeController extends ControllerBase
{
    public function indexAction()
    {
        $list_service = $this->getParameter();
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $paginator = new PaginatorModel(
            array(
                'data' => $list_service,
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
        $data = array('processing_id' => -1, 'processing_active' => 'Y','processing_order' => 1);
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'processing_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'processing_active' => $this->request->getPost("radActive"),
                'processing_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'processing_fee' => $this->request->getPost("txtFee", array('string', 'trim')),
                'processing_date' => $this->request->getPost("txtDate", array('string', 'trim')),
            );
            if (empty($data['processing_name'])) {
                $messages['processing_name'] = "Name field is required.";
            }
            if (empty($data["processing_fee"])) {
                $messages["processing_fee"] = "Fee field is required.";
            } elseif (!is_numeric($data['processing_fee'])) {
                $messages["processing_fee"] = "Fee  is number.";
            }
            if (empty($data["processing_date"])) {
                $messages["processing_date"] = "Date field is required.";
            } elseif (!is_numeric($data['processing_date'])) {
                $messages["processing_date"] = "Date  is number.";
            }
            if (empty($data["processing_order"])) {
                $messages["processing_order"] = "Order field is required.";
            } elseif (!is_numeric($data['processing_order'])) {
                $messages["processing_order"] = "Order  is number.";
            }
            if (count($messages) == 0) {
                $new_processing = new VisaProcessingFee();
                $message = "We can't store your info now:" . "<br/>";
                if ($new_processing->save($data)) {
                    $message = 'Create the Processing Fee ID: ' . $new_processing->getProcessingId() . ' success.';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    foreach ($new_processing->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result = array('status' => 'error', 'msg' => $message);
                }
                $this->session->set('msg_result', $msg_result);
                $this->response->redirect("/processingfee");
                return;
            }
        }
        $messages["status"] = "border-red";
        $data['mode'] = 'create';
        $this->view->setVars(array(
            'title' => 'Create Car',
            'formData' => $data,
            'messages' => $messages,
        ));
    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $processing_model = ProcessingFee::findFirstById($id);
        if(empty($processing_model))
        {
            return $this->response->redirect('notfound');
        }
        $data_post = $processing_model->toArray();
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
                $data_post['processing_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                if (empty($data_post['processing_name'])) {
                    $messages[$save_mode]['processing_name'] = 'Name field is required.';
                }
            } else {
                $data_post['processing_active'] =  $this->request->getPost("radActive", array('string', 'trim'));
                $data_post['processing_order'] =  $this->request->getPost("txtOrder", array('string', 'trim'));
                $data_post['processing_fee'] = $this->request->getPost("txtFee", array('string', 'trim'));
                $data_post['processing_date'] = $this->request->getPost("txtDate", array('string', 'trim'));

                if (empty($data_post["processing_order"])) {
                    $messages["processing_order"] = "Order field is required.";
                } elseif (!is_numeric($data_post['processing_order'])) {
                    $messages["processing_order"] = "Order  is number.";
                }
                if (empty($data_post["processing_fee"])) {
                    $messages["processing_fee"] = "Fee field is required.";
                } elseif (!is_numeric($data_post['processing_fee'])) {
                    $messages["processing_fee"] = "Fee  is number.";
                }
                if (empty($data_post["processing_date"])) {
                    $messages["processing_date"] = "Date field is required.";
                } elseif (!is_numeric($data_post['processing_date'])) {
                    $messages["processing_date"] = "Date  is number.";
                }

            }
            if(empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $processing_model->update($data_post);
                        $info = VisaLanguage::GENERAL;

                        break;
                    case $this->globalVariable->defaultLanguage :
                        $processing_model->setProcessingName($data_post['processing_name']);
                        $result = $processing_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $processing_lang_model = ProcessingFeeLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$processing_lang_model) {
                            $processing_lang_model = new VisaProcessingFeeLang();
                            $processing_lang_model->setProcessingId($id);
                            $processing_lang_model->setProcessingLangCode($save_mode);
                        }
                        $processing_lang_model->setProcessingName($data_post['processing_name']);
                        $result = $processing_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Processing Fee success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Processing Fee fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'processing_id' =>$processing_model->getProcessingId(),
            'processing_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['processing_name']:$processing_model->getProcessingName(),
        );
        $arr_translate[$lang_default] = $item;
        $arr_processing_lang = ProcessingFeeLang::findById($id);
        foreach ($arr_processing_lang as $processing_lang){
            $item = array(
                'processing_id'=>$processing_lang->getProcessingId(),
                'processing_name'=>($save_mode === $processing_lang->getProcessingLangCode())?$data_post['processing_name']:$processing_lang->getProcessingName(),
            );
            $arr_translate[$processing_lang->getProcessingLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'processing_id'=> -1,
                'processing_name'=> $data_post['processing_name'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'processing_id'=>$processing_model->getProcessingId(),
            'processing_active' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['processing_active']:$processing_model->getProcessingActive(),
            'processing_order' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['processing_order']:$processing_model->getProcessingOrder(),
            'processing_fee' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['processing_fee']:$processing_model->getProcessingFee(),
            'processing_date' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['processing_date']:$processing_model->getProcessingDate(),
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
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaProcessingFee AS m WHERE 1 ";
        if (!empty($keyword)) {
            $sql .= " AND m.processing_id  = :keyword: OR m.processing_name like CONCAT('%',:keyword:,'%') ";
            $arrParameter['keyword'] = $keyword;
            $this->dispatcher->setParam("txtSearch", $keyword);
        }

        $sql .= " ORDER BY m.processing_id DESC";
        return $this->modelsManager->executeQuery($sql, $arrParameter);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                $item = ProcessingFee::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Car ID = ' . $item->getProcessingId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        ProcessingFeeLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' Processing Fee successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/processingfee');
    }

}