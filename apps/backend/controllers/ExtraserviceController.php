<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaExtraservice;
use Indianimmigrationorg\Models\VisaExtraserviceLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\ExtraService;
use Indianimmigrationorg\Repositories\ExtraServiceLang;
use Indianimmigrationorg\Utils\Validator;

class ExtraserviceController extends ControllerBase
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
        $data = array('service_id' => -1, 'service_active' => 'Y','service_order' => 1);
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'service_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'service_active' => $this->request->getPost("radActive"),
                'service_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'service_listed_price' => $this->request->getPost("txtListedPrice", array('string', 'trim')),
                'service_price' => $this->request->getPost("txtPrice", array('string', 'trim')),
                'service_discount' => $this->request->getPost("txtDiscount", array('string', 'trim')),
                'service_description' => trim($this->request->getPost("txtDescription")),
            );
            if (empty($data['service_name'])) {
                $messages['service_name'] = "Name field is required.";
            }
            if (empty($data["service_listed_price"])) {
                $messages["service_listed_price"] = "Listed Price field is required.";
            } elseif (!is_numeric($data['service_listed_price'])) {
                $messages["service_listed_price"] = "Listed Price  is number.";
            }
            if (empty($data["service_price"])) {
                $messages["service_price"] = "Price field is required.";
            } elseif (!is_numeric($data['service_price'])) {
                $messages["service_price"] = "Price  is number.";
            }
            if (empty($data["service_order"])) {
                $messages["service_order"] = "Order field is required.";
            } elseif (!is_numeric($data['service_order'])) {
                $messages["service_order"] = "Order  is number.";
            }
            if (count($messages) == 0) {
                $new_service = new VisaExtraService();
                $message = "We can't store your info now:" . "<br/>";
                if ($new_service->save($data)) {
                    $message = 'Create the Extra Service ID: ' . $new_service->getServiceId() . ' success.';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    foreach ($new_service->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result = array('status' => 'error', 'msg' => $message);
                }
                $this->session->set('msg_result', $msg_result);
                $this->response->redirect("/extraservice");
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
        $service_model = ExtraService::findFirstById($id);
        if(empty($service_model))
        {
            return $this->response->redirect('notfound');
        }
        $data_post = $service_model->toArray();
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
                $data_post['service_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                $data_post['service_description'] = trim($this->request->getPost("txtDescription"));
                if (empty($data_post['service_name'])) {
                    $messages[$save_mode]['service_name'] = 'Name field is required.';
                }
            } else {
                $data_post['service_active'] =  $this->request->getPost("radActive", array('string', 'trim'));
                $data_post['service_order'] =  $this->request->getPost("txtOrder", array('string', 'trim'));
                $data_post['service_listed_price'] = $this->request->getPost("txtListedPrice", array('string', 'trim'));
                $data_post['service_price'] = $this->request->getPost("txtPrice", array('string', 'trim'));
                $data_post['service_discount'] = $this->request->getPost("txtDiscount", array('string', 'trim'));
                if (empty($data_post["service_order"])) {
                    $messages["service_order"] = "Order field is required.";
                } elseif (!is_numeric($data_post['service_order'])) {
                    $messages["service_order"] = "Order  is number.";
                }
                if (empty($data_post["service_listed_price"])) {
                    $messages["service_listed_price"] = "Listed Price field is required.";
                } elseif (!is_numeric($data_post['service_listed_price'])) {
                    $messages["service_listed_price"] = "Listed Price  is number.";
                }
                if (empty($data_post["service_price"])) {
                    $messages["service_price"] = "Price field is required.";
                } elseif (!is_numeric($data_post['service_price'])) {
                    $messages["service_price"] = "Price  is number.";
                }

            }
            if(empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $service_model->update($data_post);
                        $info = VisaLanguage::GENERAL;

                        break;
                    case $this->globalVariable->defaultLanguage :
                        $service_model->setServiceName($data_post['service_name']);
                        $service_model->setServiceDescription($data_post['service_description']);
                        $result = $service_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $service_lang_model = ExtraserviceLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$service_lang_model) {
                            $service_lang_model = new VisaExtraServiceLang();
                            $service_lang_model->setServiceId($id);
                            $service_lang_model->setServiceLangCode($save_mode);
                        }
                        $service_lang_model->setServiceName($data_post['service_name']);
                        $service_lang_model->setServiceDescription($data_post['service_description']);
                        $result = $service_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Extra Service success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Extra Service fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'service_id' =>$service_model->getServiceId(),
            'service_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['service_name']:$service_model->getServiceName(),
            'service_description'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['service_description']:$service_model->getServiceDescription(),
        );
        $arr_translate[$lang_default] = $item;
        $arr_service_lang = ExtraserviceLang::findById($id);
        foreach ($arr_service_lang as $service_lang){
            $item = array(
                'service_id'=>$service_lang->getServiceId(),
                'service_name'=>($save_mode === $service_lang->getServiceLangCode())?$data_post['service_name']:$service_lang->getServiceName(),
                'service_description'=>($save_mode === $service_lang->getServiceLangCode())?$data_post['service_description']:$service_lang->getServiceDescription(),
            );
            $arr_translate[$service_lang->getServiceLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'service_id'=> -1,
                'service_name'=> $data_post['service_name'],
                'service_description'=> $data_post['service_description'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'service_id'=>$service_model->getServiceId(),
            'service_active' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['service_active']:$service_model->getServiceActive(),
            'service_order' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['service_order']:$service_model->getServiceOrder(),
            'service_listed_price' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['service_listed_price']:$service_model->getServiceListedPrice(),
            'service_price' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['service_price']:$service_model->getServicePrice(),
            'service_discount' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['service_discount']:$service_model->getServiceDiscount(),
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
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaExtraService AS m WHERE 1 ";
        if (!empty($keyword)) {
            $sql .= " AND m.service_id  = :keyword: OR m.service_name like CONCAT('%',:keyword:,'%') ";
            $arrParameter['keyword'] = $keyword;
            $this->dispatcher->setParam("txtSearch", $keyword);
        }

        $sql .= " ORDER BY m.service_id DESC";
        return $this->modelsManager->executeQuery($sql, $arrParameter);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                $item = Extraservice::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Car ID = ' . $item->getServiceId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        ExtraserviceLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' ExtraService successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/extraservice');
    }

}