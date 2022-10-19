<?php
namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Repositories\Port;
use Indianimmigrationorg\Models\VisaPort;
use Indianimmigrationorg\Repositories\PortType;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class PortController extends ControllerBase
{
    public function indexAction()
    {
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1)
            $current_page = 1;
        $port_type = trim($this->request->get("slcPortType"));
        $keyword = trim($this->request->get("txtSearch"));
        $sql = VisaPort::query();
        if (!empty($keyword)) {
            if ($validator->validInt($keyword)) {
                $sql->andwhere("port_id = :keyword:",["keyword" => $keyword]);
            } else {
                $sql->andwhere("port_name like CONCAT('%',:keyword:,'%')",["keyword" => $keyword]);
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if (!empty($port_type)) {
            $sql->andwhere("port_type_id =:type_id:",["type_id" => $port_type]);
            $this->dispatcher->setParam("slcPortType", $port_type);
        }
        $sql->orderBy("port_id DESC");
        $list_port = $sql->execute();
        $paginator = new PaginatorModel(array(
            'data' => $list_port,
            'limit' => 20,
            'page' => $current_page,
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
        $select_port_type = PortType::getCombobox($port_type);
        $this->view->setVars(array(
            'list_port' => $paginator->getPaginate(),
            'select_port_type' => $select_port_type,
        ));
    }


    public function createAction()
    {
        $this->view->pick($this->controllerName.'/model');
        $data = array('port_id' => -1, 'port_active' => 'Y', 'port_order' => 1, 'port_type_id' => 0);
        if ($this->request->isPost()) {
            $messages = array();
            $data = array(
                'port_type_id' => $this->request->getPost("slcType"),
                'port_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'port_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'port_active' => $this->request->getPost("radActive"),
            );
            if ($data["port_type_id"] == '') {
                $messages["port_type_id"] = "Port Type field is required.";
            }
            if (empty($data["port_name"])) {
                $messages["name"] = "Name field is required.";
            }
            if (empty($data['port_order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["port_order"])) {
                $messages["order"] = "Order is not valid ";
            }
            if (count($messages) == 0) {
                $msg_result = array();
                $new_Port = new VisaPort();
                if ($new_Port->save($data)) {
                    $msg_result = array('status' => 'success', 'msg' => 'Create Port Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($new_Port->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }

                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/port");
            }
        }
        $select_port_type = PortType::getCombobox($$data['port_type_id']);
        $messages["status"] = "border-red";
        $this->view->setVars([
            'title' => 'Create Port',
            'formData' => $data,
            'messages' => $messages,
            'select_port_type' => $select_port_type,
        ]);
    }

    public function editAction()
    {
        $this->view->pick($this->controllerName.'/model');
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            return $this->response->redirect('notfound');
        }
        $port_model = Port::findFirstById($id);
        if (empty($port_model)) {
            return $this->response->redirect('notfound');
        }
        $model_data = $port_model->toArray();
        $input_data = $model_data;
        $messages = array();
        if ($this->request->isPost()) {
            $data = array(
                'port_id' => $id,
                'port_type_id' => $this->request->getPost("slcType"),
                'port_name' => $this->request->getPost("txtName", array('string', 'trim')),
                'port_order' => $this->request->getPost("txtOrder", array('string', 'trim')),
                'port_active' => $this->request->getPost("radActive"),
            );
            $input_data = $data;
            if ($data["port_type_id"] == '') {
                $messages["port_type_id"] = "Port Type field is required.";
            }
            if (empty($data["port_name"])) {
                $messages["name"] = "Name field is required.";
            }
            if (empty($data['port_order'])) {
                $messages["order"] = "Order field is required.";
            } else if (!is_numeric($data["port_order"])) {
                $messages["order"] = "Order is not valid ";
            }
            if (count($messages) == 0) {
                $msg_result = array();
                if ($port_model->update($data)) {
                    $msg_result = array('status' => 'success', 'msg' => 'Edit Port Success');
                } else {
                    $message = "We can't store your info now: \n";
                    foreach ($port_model->getMessages() as $msg) {
                        $message .= $msg . "\n";
                    }
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                }
                $this->session->set('msg_result', $msg_result);
                return $this->response->redirect("/port");
            }
        }
        $select_port_type = PortType::getCombobox($input_data['port_type_id']);
        $messages["status"] = "border-red";
        $this->view->setVars([
            'formData' => $input_data,
            'messages' => $messages,
            'select_port_type' => $select_port_type,
        ]);
    }

    public function deleteAction()
    {
        $port_checked = $this->request->getPost("item");
        if (!empty($port_checked)) {
            $tn_log = array();
            foreach ($port_checked as $id) {
                $port_item = Port::findFirstById($id);
                if ($port_item) {
                    $msg_result = array();
                    if ($port_item->delete() === false) {
                        $message_delete = 'Can\'t delete the Port Name = ' . $port_item->getPortName();
                        $msg_result['status'] = 'error';
                        $msg_result['msg'] = $message_delete;
                    } else {
                        $tn_log[$id] = $port_item->toArray();
                    }
                }
            }
            if (count($tn_log) > 0) {
                $message_delete = 'Delete ' . count($tn_log) . ' Port successfully.';
                $msg_result['status'] = 'success';
                $msg_result['msg'] = $message_delete;
            }
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect("/port");
        }
    }
}
