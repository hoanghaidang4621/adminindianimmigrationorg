<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\Role;
use Indianimmigrationorg\Repositories\SiteInfo;
use Indianimmigrationorg\Repositories\User;
use Indianimmigrationorg\Repositories\UserSiteInfoCorp;
use Indianimmigrationorg\Utils\Validator;
use Indianimmigrationorg\Utils\PasswordGenerator;

class UserController extends ControllerBase
{
    public function indexAction()
    {
        $data = $this->getParameter();
        $count_sql = "SELECT COUNT(*) AS count ";
        $select_sql = "SELECT u.user_id, u.user_insert_time, u.user_name, u.user_email, u.user_role,u.user_active, 
                       u.user_telapi_international_format, u.user_country_id ";
        $current_page = $this->request->get("page");
        $limit = 20;
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1) {
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;
        $count_user = $this->modelsManager->executeQuery($count_sql . $data['sql'], $data['para'])[0]->count;
        $limit_sql = " ORDER BY u.user_id DESC  LIMIT $limit OFFSET $start";
        $list_user_limit = $this->modelsManager->executeQuery($select_sql . $data['sql'] . $limit_sql, $data['para']);
        $total_record = $count_user;
        $total_page = floor($count_user / $limit);
        if ($count_user % $limit > 0) {
            $total_page++;
        }
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
            'list_user' => $list_user_limit,
            'total_page' => $total_page,
            'current_page' => $current_page,
            "total_record" => $total_record,
            'msg_result' => $msg_result,
            'msg_delete' => $msg_delete,
        ));
    }

    public function exportcsvAction()
    {
        $this->view->disable();
        $data = $this->getParameter();
        $select_sql = "SELECT DISTINCT u.user_id, u.user_name, u.user_country_id ";
        $list_user = $this->modelsManager->executeQuery($select_sql . $data['sql'], $data['para'])->toArray();
        $results = $this->getDataExportCSV($list_user);
        $file_name = "user_";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $file_name . time() . '.csv');
        echo "\xEF\xBB\xBF";
        $out = fopen('php://output', 'w');
        foreach ($results as $fields) {
            fputcsv($out, $fields);
        }
        fclose($out);
        die();
    }

    public function exportcsvmktAction()
    {
        $this->view->disable();
        $data = $this->getParameter();
        $select_sql = "SELECT DISTINCT u.user_id, u.user_name, u.user_email, u.user_insert_time ";
        $list_user = $this->modelsManager->executeQuery($select_sql . $data['sql'], $data['para']);
        $results = $this->getDataExportCSVForMarketting($list_user);
        $file_name = "userMKT_";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $file_name . time() . '.csv');
        echo "\xEF\xBB\xBF";
        $out = fopen('php://output', 'w');
        foreach ($results as $fields) {
            fputcsv($out, $fields);
        }
        fclose($out);
        die();

    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $user_model = User::findFirstById($id);
        $user_site_info = SiteInfo::findFirstById($id, $this->globalVariable->site_id);
        if (empty($user_model) || (empty($user_site_info))) {
            $this->response->redirect('notfound');
            return;
        }
        if ($this->session->has('msg_information')) {
            $msg_information = $this->session->get('msg_information');
            $this->session->remove('msg_information');
            $this->view->msg_information = $msg_information;
        }
        if ($this->session->has('messages')) {
            $messages = $this->session->get('messages');
            $this->session->remove('messages');
            $this->view->messages = $messages;
        }
        if ($this->session->has('input_data')) {
            $input_data = $this->session->get('input_data');
            $this->session->remove('input_data');
        }
        if ($this->session->has('msg_password')) {
            $msg_password = $this->session->get('msg_password');
            $this->session->remove('msg_password');
            $this->view->msg_password = $msg_password;
        }
        if ($this->session->has('msg_role')) {
            $msg_role = $this->session->get('msg_role');
            $this->session->remove('msg_role');
            $this->view->msg_role = $msg_role;
        }
        $data = array(
            'user_id' => $user_model->getUserId(),
            'user_email' => isset($input_data['user_email']) ? $input_data['user_email'] : $user_model->getUserEmail(),
            'user_tel' => isset($input_data['user_tel']) ? $input_data['user_tel'] : $user_model->getUserTel(),
            'user_telapi_international_format' => isset($input_data['user_telapi_international_format']) ? $input_data['user_telapi_international_format'] : $user_model->getUserTelapiInternationalFormat(),
            'user_telapi_country_code' => isset($input_data['user_telapi_country_code']) ? $input_data['user_telapi_country_code'] : $user_model->getUserTelapiCountryCode(),
            'user_name' => isset($input_data['user_first_name']) ? $input_data['user_first_name'] : $user_model->getUserName(),
            'user_role' => isset($input_data['user_role']) ? $input_data['user_role'] : $user_model->getUserRole(),
            'user_is_subscribe' => isset($input_data['user_is_subscribe']) ? $input_data['user_is_subscribe'] : $user_site_info->getUserIsSubscribe(),
            'user_active' => isset($input_data['user_active']) ? $input_data['user_active'] : $user_model->getUserActive(),
            'user_insert_time' => $user_model->getUserInsertTime(),
        );
        $strRole = Role::getComboBox($data['user_role']);
        $this->view->setVars(array(
            'data' => $data,
            'slcRole' => $strRole,
        ));
    }

    public function informationAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $user_site_info = SiteInfo::findFirstById($id, $this->globalVariable->site_id);
        if (!$user_site_info) {
            $this->response->redirect('notfound');
            return;
        }
        $messages = array();
        if ($this->request->isPost()) {
            $input_data = array(
                'user_is_subscribe' => $this->request->getPost('radIsSubscribe'),
            );
            if (count($messages) == 0) {
                $result = $user_site_info->update($input_data);
                if ($result === false) {
                    $message = "Edit User fail !";
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                } else {
                    $msg_result = array('status' => 'success', 'msg' => 'Edit User Success');
                }
                $this->session->set('msg_information', $msg_result);
            } else {
                $messages['status'] = 'border-red';
                $this->session->set('input_data', $input_data);
                $this->session->set('messages', $messages);
            }
        }
        return $this->response->redirect("user/edit?id=" . $id);
    }

    public function passwordAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $user_model = User::findFirstById($id);
        if (empty($user_model)) {
            $this->response->redirect('notfound');
            return;
        }
        if ($this->request->isPost()) {
            $input_data = array(
                'user_password' => $this->request->getPost('txtPassword', array('string', 'trim')),
            );
            $data = $input_data;
            $messages = array();
            if (empty($data['user_password'])) {
                $messages['password'] = 'New Password field is required.';
            }
            if (count($messages) == 0) {
                $tokenGenerator = new PasswordGenerator();
                $password = $tokenGenerator->encodePass($data['user_password']);
                $user_model->setUserPassword($password);
                $result = $user_model->update();
                if ($result === false) {
                    $message = "Change Password fail !";
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                } else {
                    $msg_result = array('status' => 'success', 'msg' => 'Change Password Success');
                }
                $this->session->set('msg_password', $msg_result);
            }
        }
        return $this->response->redirect("user/edit?id=" . $id);
    }

    public function roleAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $user_model = User::findFirstById($id);
        if (empty($user_model)) {
            $this->response->redirect('notfound');
            return;
        }
        if ($this->request->isPost()) {
            $input_data = array(
                'user_role' => $this->request->getPost('slcRole'),
            );
            $data = $input_data;
            $messages = array();
            if ($data['user_role'] == '') {
                $messages['role'] = 'Role field is required.';
            }
            if (count($messages) == 0) {
                $user_model->setUserRole($data['user_role']);
                $result = $user_model->update();
                if ($result === false) {
                    $message = "Update Role fail !";
                    $msg_result['status'] = 'error';
                    $msg_result['msg'] = $message;
                } else {
                    $msg_result = array('status' => 'success', 'msg' => 'Update Role Success');

                }
                $this->session->set('msg_role', $msg_result);
            }
        }
        return $this->response->redirect("user/edit?id=" . $id);
    }

    public function deleteAction()
    {
        $list_user = $this->request->get('item');
        $Content_user = array();
        $msg_delete = array('error' => '', 'success' => '');
        if ($list_user) {
            foreach ($list_user as $user_id) {
                $user_model = UserSiteInfoCorp::findFirstByUserSite($user_id, $this->globalVariable->site_id);
                if ($user_model) {
                    $table_names = array();
                    $message_temp = "Can't delete ID = " . $user_model->getUserId() . ". Because It's exist in";
                    if (empty($table_names)) {
                        $old_user_data = $user_model->toArray();
                        $new_user_data = array();
                        $Content_user[$user_id] = array($old_user_data, $new_user_data);
                        $user_model->delete();
                    } else {
                        $msg_delete['error'] .= $message_temp . implode(",", $table_names) . "<br>";
                    }
                }
            }
        }
        if (count($Content_user) > 0) {
            // delete success
            $message = 'Delete ' . count($Content_user) . ' user success.';
            $msg_delete['success'] = $message;

        }
        $this->session->set('msg_delete', $msg_delete);
        $this->response->redirect('/user');
        return;
    }

    private function getParameter()
    {
        $sql = "FROM Visacorp\Models\UserCorp u
              INNER JOIN Visacorp\Models\UserSiteInfo i  ON i.user_id = u.user_id AND i.user_site_id = :siteID: 
              WHERE 1";
        $arrParameter['siteID'] = $this->globalVariable->site_id;
        $keyword = trim($this->request->get("txtSearch"));
        $from = trim($this->request->get("txtFrom")); //string
        $to = trim($this->request->get("txtTo"));  //string
        $active = trim($this->request->get("slcActive"));  //string
        $subscribe = trim($this->request->get("slcSubscribe"));  //string
        $validator = new Validator();
        if (!empty($keyword)) {
            if ($validator->validInt($keyword)) {
                $sql .= " AND (u.user_id = :number:)";
                $arrParameter['number'] = $this->my->getIdFromFormatID($keyword, true);
            } else {
                $sql .= " AND (u.user_name like CONCAT('%',:keyword:,'%')  OR u.user_email like CONCAT('%',:keyword:,'%') ) ";
                $arrParameter['keyword'] = $keyword;
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if ($from) {
            $intFrom = $this->my->UTCTime(strtotime($from)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND u.user_insert_time >= :from:";
            $arrParameter['from'] = $intFrom;
            $this->dispatcher->setParam("txtFrom", $from);
        }
        if ($to) {
            $intTo = $this->my->UTCTime(strtotime($to)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND u.user_insert_time <= :to:";
            $arrParameter['to'] = $intTo;
            $this->dispatcher->setParam("txtTo", $to);
        }
        if ($active) {
            $sql .= " AND u.user_active = :active:";
            $arrParameter['active'] = $active;
            $this->dispatcher->setParam("slcActive", $active);
        }
        if ($subscribe) {
            $sql .= " AND i.user_is_subscribe = :subscribe:";
            $arrParameter['subscribe'] = $subscribe;
            $this->dispatcher->setParam("slcSubscribe", $subscribe);
        }
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }

    private function getDataExportCSV($list_user)
    {

        $arrUserID = array_values(array_column($list_user, 'user_id'));
        $arrUserID = array_merge([-1], $arrUserID);
        $strUserID = implode(',', $arrUserID);
        $connection = $this->di->getShared('db');

        $sql = "
            select  t1.order_user_id,
                            count(case when order_status = 'Success' then 1 end) as order_success,
                            count(case when order_status = 'Pending' then 1 end) as order_pending,
                            count(case when order_status = 'Cancel' then 1 end)  as order_fail,
                            count(case when order_full_package > 0 then 1 end)   as order_full_package,
                            (case when isnull(order_insurrance_fee) OR order_insurrance_fee = 0 then 0 else 1 end + order_insurrance_count) as order_insurrance_total,
                            (case when isnull(order_4g_sim_card) OR order_4g_sim_card = 0 then 0 else 1 end + order_4g_sim_card_count) as order_4g_sim_card_total
                    from visa_order t1
                    left join
                        (select order_id,
                                count(case when order_service_id = 322 then 1 end) as order_insurrance_count,
                                count(case when order_service_id = 321 then 1 end) as order_4g_sim_card_count
                        from visa_order_detail
                        group by order_id) as t2 on t1.order_id = t2.order_id
        where order_user_id IN ($strUserID)                        
        group by t1.order_user_id 
        order by order_user_id";
        $resultsUser = $connection->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        $results[] = array("ID User", "User Name", "User Nationality", "Order - Sucess", "Order -  Cancel", "Order - Pending", "Order Full Package", "Order Covid-19 Insurance", "Order Travel Sim");
        foreach ($list_user as $user) {
            $key = array_search($user['user_id'], array_column($resultsUser, 'order_user_id'));

            $order_success = ($key !== false) ? $resultsUser[$key]['order_success'] : 0;
            $order_fail = ($key !== false) ? $resultsUser[$key]['order_fail'] : 0;
            $order_pending = ($key !== false) ? $resultsUser[$key]['order_pending'] : 0;
            $order_full_package = ($key !== false) ? $resultsUser[$key]['order_full_package'] : 0;
            $order_insurrance_fee = ($key !== false) ? $resultsUser[$key]['order_insurrance_total'] : 0;
            $order_4g_sim_card = ($key !== false) ? $resultsUser[$key]['order_4g_sim_card_total'] : 0;
            $item = array(
                $user['user_id'],
                $user['user_name'],
                CountryGeneral::getNameByCode($user['user_country_id']),
                $order_success,
                $order_fail,
                $order_pending,
                $order_full_package,
                $order_insurrance_fee,
                $order_4g_sim_card,
            );
            $results[] = $item;
        }
        return $results;
    }

    private function getDataExportCSVForMarketting($list_user)
    {
        $results[] = array("id", "name", "email", 'insert time');

        foreach ($list_user as $item) {
            $test = array(
                $item->user_id,
                $item->user_name,
                $item->user_email,
                $item->user_insert_time,
            );
            $results[] = $test;
        }
        return $results;
    }
}