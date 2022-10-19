<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaOrder;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\Payment;
use Indianimmigrationorg\Repositories\User;
use Indianimmigrationorg\Repositories\UserSiteInfoCorp;
use Indianimmigrationorg\Repositories\UserType;
use Indianimmigrationorg\Utils\Validator;

class PaymentController extends ControllerBase
{
    public function indexAction()
    {
        $data = $this->getParameter();
        $sql_table = "FROM Indianimmigrationorg\Models\VisaPayment  p";

        $count_sql = "SELECT COUNT(*) AS count ";
        $select_sql = "SELECT p.payment_user_id,p.payment_insertdate,p.payment_method,p.payment_status,p.payment_id,p.payment_date,
                    p.payment_isenrolled3d,p.payment_ispassed3d,p.payment_amount,p.payment_status,p.payment_cardtype ";
        $current_page = $this->request->get("page");
        $limit = 20;
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1) {
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;

        $count_payment = $this->modelsManager->executeQuery($count_sql . $sql_table . $data['sql_where'], $data['para'])[0]->count;
        $limit_sql = " ORDER BY p.payment_id DESC  LIMIT $limit OFFSET $start";
        $list_payment_limit = $this->modelsManager->executeQuery($select_sql . $sql_table . $data['sql_where'] . $limit_sql, $data['para']);

        $total_record = $count_payment;
        $total_page = floor($count_payment / $limit);
        if ($count_payment % $limit > 0) {
            $total_page++;
        }
        $this->view->setVars(array(
            'list_payment' => $list_payment_limit,
            'total_page' => $total_page,
            'current_page' => $current_page,
            "total_record" => $total_record,
        ));
    }
    private function getParameter()
    {
        $sql = ' WHERE 1 ';
        $keyword = trim($this->request->get("txtSearch"));
        $from_apply = trim($this->request->get("txtFromApply"));
        $to_apply = trim($this->request->get("txtToApply"));
        $from_payment = trim($this->request->get("txtFromPayment"));
        $to_payment = trim($this->request->get("txtToPayment"));
        $method = trim($this->request->get("slcMethod"));
        $status = trim($this->request->get("slcStatus"));
        $validator = new Validator();
        $arrParameter = [];
        if (!empty($keyword)) {
            if ($validator->validInt($keyword)) {
                $sql .= " AND (p.payment_id = :number:)";
                $arrParameter['number'] = $this->my->getIdFromFormatID($keyword, true);
            } else {
                $sql .= " AND p.payment_user_id IN ({user_ids:array}) ";
                $arrParameter['user_ids'] = UserSiteInfoCorp::findIdByEmail($keyword);
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if ($from_apply) {
            $intFrom = $this->my->UTCTime(strtotime($from_apply)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND p.payment_insertdate >= :from_apply:";
            $arrParameter['from_apply'] = $intFrom;
            $this->dispatcher->setParam("txtFromApply", $from_apply);
        }
        if ($to_apply) {
            $intTo = $this->my->UTCTime(strtotime($to_apply)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND p.payment_insertdate <= :to_apply:";
            $arrParameter['to_apply'] = $intTo;
            $this->dispatcher->setParam("txtToApply", $to_apply);
        }
        if ($from_payment) {
            $intFrom = $this->my->UTCTime(strtotime($from_payment)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND p.payment_date >= :from_payment:";
            $arrParameter['from_payment'] = $intFrom;
            $this->dispatcher->setParam("txtFromPayment", $from_payment);
        }
        if ($to_payment) {
            $intTo = $this->my->UTCTime(strtotime($to_payment)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND p.payment_date <= :to_payment:";
            $arrParameter['to_payment'] = $intTo;
            $this->dispatcher->setParam("txtToPayment", $to_payment);
        }

        if ($status) {
            $sql .= " AND p.payment_status  = :status:";
            $arrParameter['status'] = $status;
            $this->dispatcher->setParam("slcStatus", $status);
        }
        if ($method) {
            $sql .= " AND p.payment_method = :method:";
            $arrParameter['method'] = $method;
            $this->dispatcher->setParam("slcMethod", $method);
        }
        $data['para'] = $arrParameter;
        $data['sql_where'] = $sql;
        return $data;
    }
    public function viewAction(){
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $payment_model = Payment::findFirstById($id);
        if (empty($payment_model)) {
            $this->response->redirect('notfound');
            return;
        }
        $temp = $payment_model->toArray();
        $temp['payment_button_html'] ='';
        switch ($temp['payment_status']) {
            case VisaOrder::STATUS_SUCCESS:
                $temp['payment_button_html'] = '<a href="'.$this->url->get($this->lang_url . 'receipt/'.$payment_model->getFormattedId()).'" target="_blank" class="btn btn-success">Receipt</a>';
                break;
            case VisaOrder::STATUS_FAIL:
                $temp['payment_button_html'] = '<a href="'.$this->url->get('invoice/'.$payment_model->getFormattedId()).'" target="_blank" class="btn btn-primary" style="height: auto">Invoice</a>';
                break;
            case VisaOrder::STATUS_PENDING:
                $temp['payment_button_html'] = '<a href="'.$this->url->get('invoice/'.$payment_model->getFormattedId()).'" target="_blank" class="btn btn-primary" style="height: auto">Invoice</a>';
                break;

        }
        $temp['payment_method'] = $this->my->getMethod($temp['payment_method'], $temp['payment_card_type'], $temp['payment_isenrolled3d'], $temp['payment_ispassed3d'], true);
        $user = User::findFirstById($temp['payment_user_id']);
        if($user){
            $temp['user'] = $user->toArray();
            $temp['user']['user_type'] = UserType::getNameById($user->getUserType());
            $temp['user']['user_country_name'] = CountryGeneral::getCountryNameByCode($user->getUserCountryId());
        }
        $this->view->setVars(array(
            'payment' => $temp,
        ));
    }
}