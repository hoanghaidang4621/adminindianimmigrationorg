<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLanguage;
use Indianimmigrationorg\Models\VisaCar;
use Indianimmigrationorg\Models\VisaCarLang;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Indianimmigrationorg\Repositories\Language;
use Indianimmigrationorg\Repositories\Car;
use Indianimmigrationorg\Repositories\CarLang;
use Indianimmigrationorg\Utils\Validator;
class CarController extends ControllerBase
{
    public function indexAction()
    {
        $list_car = $this->getParameter();
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $paginator = new PaginatorModel(
            array(
                'data' => $list_car,
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
        $data = array('car_id' => -1, 'car_active' => 'Y','car_order' => 1);
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'car_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'car_active' => $this->request->getPost("radActive"),
                'car_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
            );
            if (empty($data['car_name'])) {
                $messages['car_name'] = "Name field is required.";
            }
            if (empty($data["car_order"])) {
                $messages["car_order"] = "Order field is required.";
            } elseif (!is_numeric($data['car_order'])) {
                $messages["car_order"] = "Order  is number.";
            }
            if (count($messages) == 0) {
                $new_car = new VisaCar();
                $message = "We can't store your info now:" . "<br/>";
                if ($new_car->save($data)) {
                    $message = 'Create the Car ID: ' . $new_car->getCarId() . ' success.';
                    $msg_result = array('status' => 'success', 'msg' => $message);
                } else {
                    foreach ($new_car->getMessages() as $msg) {
                        $message .= $msg . "<br/>";
                    }
                    $msg_result = array('status' => 'error', 'msg' => $message);
                }
                $this->session->set('msg_result', $msg_result);
                $this->response->redirect("/car");
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
        $car_model = Car::findFirstById($id);
        if(empty($car_model))
        {
            return $this->response->redirect('notfound');
        }
        $data_post = $car_model->toArray();
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
                $data_post['car_name'] = $this->request->getPost("txtName", array('string', 'trim'));
                if (empty($data_post['car_name'])) {
                    $messages[$save_mode]['car_name'] = 'Name field is required.';
                }
            } else {
                $data_post['car_active'] =  $this->request->getPost("radActive", array('string', 'trim'));
                $data_post['car_order'] =  $this->request->getPost("txtOrder", array('string', 'trim'));
                if (empty($data_post["car_order"])) {
                    $messages["car_order"] = "Order field is required.";
                } elseif (!is_numeric($data_post['car_order'])) {
                    $messages["car_order"] = "Order  is number.";
                }

            }
            if(empty($messages)) {
                switch ($save_mode) {
                    case VisaLanguage::GENERAL:
                        $result = $car_model->update($data_post);
                        $info = VisaLanguage::GENERAL;

                        break;
                    case $this->globalVariable->defaultLanguage :
                        $car_model->setCarName($data_post['car_name']);
                        $result = $car_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                    default:
                        $car_lang_model = CarLang::findFirstByIdAndLang($id, $save_mode);
                        if (!$car_lang_model) {
                            $car_lang_model = new VisaCarLang();
                            $car_lang_model->setCarId($id);
                            $car_lang_model->setCarLangCode($save_mode);
                        }
                        $car_lang_model->setCarName($data_post['car_name']);
                        $result = $car_lang_model->save();
                        $info = $arr_language[$save_mode];
                        break;
                }
                if ($result) {
                    $messages = array(
                        'message' => ucfirst($info . " Update Car success"),
                        'typeMessage' => "success",
                    );
                }else{
                    $messages = array(
                        'message' => "Update Car fail",
                        'typeMessage' => "error",
                    );
                }
            }
        }
        $item = array(
            'car_id' =>$car_model->getCarId(),
            'car_name'=>($save_mode === $this->globalVariable->defaultLanguage)?$data_post['car_name']:$car_model->getCarName(),
        );
        $arr_translate[$lang_default] = $item;
        $arr_car_lang = CarLang::findById($id);
        foreach ($arr_car_lang as $car_lang){
            $item = array(
                'car_id'=>$car_lang->getCarId(),
                'car_name'=>($save_mode === $car_lang->getCarLangCode())?$data_post['car_name']:$car_lang->getCarName(),
            );
            $arr_translate[$car_lang->getCarLangCode()] = $item;
        }
        if(!isset($arr_translate[$save_mode])&& isset($arr_language[$save_mode])){
            $item = array(
                'car_id'=> -1,
                'car_name'=> $data_post['car_name'],
            );
            $arr_translate[$save_mode] = $item;
        }
        $formData = array(
            'car_id'=>$car_model->getCarId(),
            'car_active' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['car_active']:$car_model->getCarActive(),
            'car_order' => ($save_mode ===VisaLanguage::GENERAL)?$data_post['car_order']:$car_model->getCarOrder(),
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
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaCar AS m WHERE 1 ";
        if (!empty($keyword)) {
            $sql .= " AND m.car_id  = :keyword: OR m.car_name like CONCAT('%',:keyword:,'%') ";
            $arrParameter['keyword'] = $keyword;
            $this->dispatcher->setParam("txtSearch", $keyword);
        }

        $sql .= " ORDER BY m.car_id DESC";
        return $this->modelsManager->executeQuery($sql, $arrParameter);
    }

    public function deleteAction()
    {
        $items_checked = $this->request->getPost("item");
        if (!empty($items_checked)) {
            $msg_result = array();
            $count_delete = 0;
            foreach ($items_checked as $id) {
                $item = Car::findFirstById($id);
                if ($item) {
                    if ($item->delete() === false) {
                        $message_delete = 'Can\'t delete the Car ID = ' . $item->getCarId();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] .= $message_delete;
                    }else{
                        $count_delete ++;
                        CarLang::deleteById($id);
                    }
                }
            }
        }
        if ($count_delete > 0) {
            $message_delete = 'Delete ' . $count_delete . ' Car successfully' . "<br>";
            $msg_result['status'] = 'success';
            $msg_result['msg'] .= $message_delete;
        }
        $this->session->set('msg_result', $msg_result);
        return $this->response->redirect('/car');
    }

}