<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaExtraService;
use Indianimmigrationorg\Models\VisaOrder;
use Indianimmigrationorg\Models\VisaOrderMember;
use Indianimmigrationorg\Models\VisaPayment;
use Indianimmigrationorg\Repositories\Country;
use Indianimmigrationorg\Repositories\CountryGeneral;
use Indianimmigrationorg\Repositories\ExtraService;
use Indianimmigrationorg\Repositories\Order;
use Indianimmigrationorg\Repositories\OrderDetail;
use Indianimmigrationorg\Repositories\OrderMember;
use Indianimmigrationorg\Repositories\OrderReceipt;
use Indianimmigrationorg\Repositories\Payment;
use Indianimmigrationorg\Repositories\Port;
use Indianimmigrationorg\Repositories\PortType;
use Indianimmigrationorg\Repositories\ProcessingFee;
use Indianimmigrationorg\Repositories\User;
use Indianimmigrationorg\Repositories\UserSiteInfoCorp;
use Indianimmigrationorg\Repositories\UserType;
use Indianimmigrationorg\Repositories\VisaType;
use Indianimmigrationorg\Utils\Validator;

class OrderController extends ControllerBase
{
    public function indexAction()
    {
        $data = $this->getParameter();
        $sql_table = "FROM Indianimmigrationorg\Models\VisaOrder  o
                LEFT JOIN Indianimmigrationorg\Models\VisaReceipt r ON r.receipt_order_id = o.order_id";

        $count_sql = "SELECT COUNT(*) AS count ";
        $select_sql = "SELECT o.order_user_id,o.order_register_date,o.order_payment_method,o.order_status,o.order_id,r.receipt_pay_date,
                    o.order_isenrolled3d,o.order_ispassed3d,o.order_total,o.order_status,o.order_cardtype ";
        $current_page = $this->request->get("page");
        $limit = 20;
        $validator = new Validator();
        if ($validator->validInt($current_page) == false || $current_page < 1) {
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;
        $count_order = $this->modelsManager->executeQuery($count_sql . $sql_table . $data['sql_where'], $data['para'])[0]->count;
        $limit_sql = " ORDER BY o.order_id DESC  LIMIT $limit OFFSET $start";
        $list_order_limit = $this->modelsManager->executeQuery($select_sql . $sql_table . $data['sql_where'] . $limit_sql, $data['para']);
        $total_record = $count_order;
        $total_page = floor($count_order / $limit);
        if ($count_order % $limit > 0) {
            $total_page++;
        }

        $this->view->setVars(array(
            'list_order' => $list_order_limit,
            'total_page' => $total_page,
            'current_page' => $current_page,
            "total_record" => $total_record,
        ));
    }

    public function exportcsvAction()
    {
        $this->view->disable();
        $data = $this->getParameter();
        $sql_select = "SELECT o.order_id,o.order_register_date, o.order_status, o.order_full_package, o.order_insurrance_fee, o.order_4g_sim_card,
                     m.member_name, c.country_name, od.service_sim_fee, od.service_insurance_fee  ";
        $sql_table = "FROM visa_order o
                    LEFT JOIN visa_receipt r ON r.receipt_order_id = o.order_id
                    LEFT JOIN visa_order_member m ON m.member_order_id = o.order_id
                    LEFT JOIN visa_country c ON c.country_id = m.member_country_id
                    LEFT JOIN (SELECT order_id,
                                SUM(CASE WHEN order_service_id = 321 THEN order_service_fee END )  service_sim_fee,
                                SUM(CASE WHEN order_service_id = 322 THEN order_service_fee END )  service_insurance_fee
                                FROM visa_order_detail
                                GROUP BY order_id) as od
                                ON o.order_id = od.order_id";
        $where = $data['sql_where'];
        foreach ($data['para'] as $key => $item) {
            if(($key == 'user_ids')||($key == 'order_ids')) {
                $where = preg_replace('/{user_ids:array}/', implode(',',$item), $where);
                $where = preg_replace('/{order_ids:array}/', implode(',',$item), $where);
            }else {
                $where = preg_replace("/:$key:/", "'$item'", $where);
            }
        }
        $connection = $this->di->getShared('db');
        $list_order = $connection->query($sql_select.$sql_table.$where)->fetchAll(\PDO::FETCH_ASSOC);
        $results = $this->getDataExportCSV($list_order);
        $file_name = "order_";
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
    private function getParameter()
    {
        $sql = ' WHERE 1 ';
        $keyword = trim($this->request->get("txtSearch"));
        $from_apply = trim($this->request->get("txtFromApply"));
        $to_apply = trim($this->request->get("txtToApply"));
        $from_payment = trim($this->request->get("txtFromPayment"));
        $to_payment = trim($this->request->get("txtToPayment"));
        $country = trim($this->request->get("slcCountry"));
        $method = trim($this->request->get("slcMethod"));
        $status = trim($this->request->get("slcStatus"));
        $checkboxTravelSim = $this->request->get("cbTravelSim");
        $checkboxInsurance = $this->request->get("cbInsurance");
        $validator = new Validator();
        $arrParameter = [];
        if (!empty($keyword)) {
            if ($validator->validInt($keyword)) {
                $sql .= " AND (o.order_id = :number:)";
                $arrParameter['number'] = $this->my->getIdFromFormatID($keyword, true);
            } else {
                $sql .= " AND o.order_user_id IN ({user_ids:array}) ";
                $arrParameter['user_ids'] = UserSiteInfoCorp::findIdByEmail($keyword);
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if ($from_apply) {
            $intFrom = $this->my->UTCTime(strtotime($from_apply)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND o.order_register_date >= :from_apply:";
            $arrParameter['from_apply'] = $intFrom;
            $this->dispatcher->setParam("txtFromApply", $from_apply);
        }
        if ($to_apply) {
            $intTo = $this->my->UTCTime(strtotime($to_apply)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND o.order_register_date <= :to_apply:";
            $arrParameter['to_apply'] = $intTo;
            $this->dispatcher->setParam("txtToApply", $to_apply);
        }
        if ($from_payment) {
            $intFrom = $this->my->UTCTime(strtotime($from_payment)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND r.receipt_pay_date >= :from_payment:";
            $arrParameter['from_payment'] = $intFrom;
            $this->dispatcher->setParam("txtFromPayment", $from_payment);
        }
        if ($to_payment) {
            $intTo = $this->my->UTCTime(strtotime($to_payment)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND r.receipt_pay_date <= :to_payment:";
            $arrParameter['to_payment'] = $intTo;
            $this->dispatcher->setParam("txtToPayment", $to_payment);
        }

        if ($status) {
            $sql .= " AND o.order_status  = :status:";
            $arrParameter['status'] = $status;
            $this->dispatcher->setParam("slcStatus", $status);
        }
        if ($method) {
            $sql .= " AND o.payment_method = :method:";
            $arrParameter['method'] = $method;
            $this->dispatcher->setParam("slcMethod", $method);
        }
        if ($country) {
            $sql .= " AND o.order_id IN ({order_ids:array}) ";
            $arrParameter['order_ids'] = OrderMember::getArrOrderIdByCountry($country);
            $this->dispatcher->setParam("slcCountry", $country);
        }
        if ($checkboxTravelSim) {
            $sql .= " AND (o.order_4g_sim_card > 0 OR o.order_id IN ({order_sim_ids:array})) ";
            $arrParameter['order_sim_ids'] = OrderDetail::getArrOrderIdByService(VisaExtraService::SERVICE_TRAVEL_SIM);
            $this->dispatcher->setParam("cbTravelSim", $checkboxTravelSim);
        }
        if ($checkboxInsurance) {
            $sql .= " AND ((o.order_insurrance_fee > 0) OR o.order_id IN ({order_insurrance_ids:array} ))";
            $arrParameter['order_insurrance_ids'] = OrderDetail::getArrOrderIdByService(VisaExtraService::SERVICE_TRAVEL_INSURANCE);
            $this->dispatcher->setParam("cbInsurance", $checkboxInsurance);
        }
        $data['para'] = $arrParameter;
        $data['sql_where'] = $sql;
        return $data;
    }

    private function getDataExportCSV($list_order)
    {
        $results[] = array("ID Order", "Passenger Name", "Passenger nationality", "Order Status", "Order Full Package", "Order Covid-19 Insurance", "Order Travel Sim");
        foreach ($list_order as $order) {
            $insurrance_fee = 0;
            if (!empty($order['order_insurrance_fee']))
                $insurrance_fee = $order['order_insurrance_fee'];
            if (!empty($order['service_insurance_fee']))
                $insurrance_fee = $order['service_insurance_fee'];
            $sim_fee = 0;
            if (!empty($order['order_4g_sim_card']))
                $sim_fee = $order['order_4g_sim_card'];
            if (!empty($order['service_sim_fee']))
                $sim_fee = $order['service_sim_fee'];
            $item = array(
                $order['order_id'],
                $order['member_name'],
                $order['country_name'],
                $order['order_status'],
                empty($order['order_full_package']) ? 0 : $order['order_full_package'],
                $insurrance_fee,
                $sim_fee,
            );
            $results[] = $item;
        }
        return $results;
    }
    public function viewAction(){
        $id = $this->request->get('id');
        $checkID = new Validator();
        if (!$checkID->validInt($id)) {
            $this->response->redirect('notfound');
            return;
        }
        $order_model = Order::findFirstById($id);
        if (empty($order_model)) {
            $this->response->redirect('notfound');
            return;
        }
        $temp = $order_model->toArray();
        $temp['order_button_html'] ='';
        switch ($temp['order_status']) {
            case VisaOrder::STATUS_SUCCESS:
                $temp['order_button_html'] = '<a href="'.$this->url->get($this->lang_url . 'receipt/'.$order_model->getFormattedId()).'" target="_blank" class="btn btn-success">Receipt</a>';
                break;
            case VisaOrder::STATUS_FAIL:
                $temp['order_button_html'] = '<a href="'.$this->url->get('invoice/'.$order_model->getFormattedId()).'" target="_blank" class="btn btn-primary" style="height: auto">Invoice</a>';
                break;
            case VisaOrder::STATUS_PENDING:
                $temp['order_button_html'] = '<a href="'.$this->url->get('invoice/'.$order_model->getFormattedId()).'" target="_blank" class="btn btn-primary" style="height: auto">Invoice</a>';
                break;

        }
        $temp['order_date_payment'] = 0;
        $receipt = OrderReceipt::findFirstByOrder($id);
        if($receipt){
            $temp['order_date_payment'] = $receipt->getReceiptPayDate();
        }
        $temp['order_method'] = $this->my->getMethod($temp['order_payment_method'], $temp['order_card_type'], $temp['order_isenrolled3d'], $temp['order_ispassed3d'], true);
        $visa_type = VisaType::findFirstById($temp['order_type_visa_id']);
        $temp['order_visa_type_name'] = ($visa_type)?$visa_type->getTypeName():"";
        $port_type = PortType::findFirstById($temp['order_arrival_port_type_id']);
        $temp['order_port_type_name'] = ($port_type)?$port_type->getTypeName():"";
        $port = Port::findFirstById($temp['order_arrival_port_id']);
        $temp['order_port_name'] = ($port)?$port->getPortName():"";
        $processing_fee = ProcessingFee::findFirstById($temp['order_processing_id']);
        $temp['order_processing_name'] = ($processing_fee)?$processing_fee->getProcessingName():"";
        $temp['order_processing_value'] = $temp['order_group_value']*$temp['order_processing_fee'];
        $temp['order_discount_user_value'] = 0;
        $temp['order_discount_user_name'] = '';
        $temp['order_service_fee'] = $temp['order_visa_fee']*($temp['order_group_value']-$temp['order_exception'])+$temp['order_exception_fee'];
        if($temp['order_user_disrate'] > 0){
            $temp['order_discount_user_value'] =$temp['order_service_fee']*$temp['order_user_disrate']/100;
            $temp['order_discount_user_name'] ='Discount For '.substr($temp['order_user_disnote'], 0, strlen($temp['order_user_disnote']) - 1) . "*" . ($temp['order_visa_fee']).')';
        }
        $temp['order_promotion_value'] = 0;
        $temp['order_promotion_name'] = '';
        if($temp['order_promotion_percent'] > 0){
            $temp['order_promotion_value'] = $temp['order_promotion_percent'] * ($temp['order_service_fee'] - $temp['order_discount_user_value']) / 100;
            $temp['order_promotion_name'] = 'Promotion discount ( - '.$temp['order_promotion_percent']. '%'.') x $'. ($temp['order_service_fee'] - $temp['order_discount_user_value']);
        }
        $temp['order_total_service'] = $temp['order_service_fee'] + $temp['order_fast_check_fee'] + $temp['order_pick_up_fee'] + $temp['order_processing_value']
            - $temp['order_promotion_value'] - $temp['order_discount_user_value'];
        $temp['government_fees'] = [];
        $order_members = OrderMember::getGovernmentFeeByOrderId($id);
        $number = 1;
        /** @var VisaOrderMember $item */
        foreach ($order_members as $item){
            $country_name = Country::getNameById($item->getMemberCountryId());
            $temp['government_fees'][] = [
                'government_name' => $number++.'. '.$country_name,
                'government_value' => $item->getMemberGovernmentFee()
            ];
        }
        $temp['order_full_package_value'] = $temp['order_full_package']*$temp['order_group_value'];
        $temp['order_extra_services'] = [];
        $order_detail = OrderDetail::findByOrder($id);
        foreach ($order_detail as $detail){
            $extraService = ExtraService::findFirstById($detail->getOrderServiceId());
            if($extraService) {
                $temp['order_extra_services'][] = [
                    'order_extra_service_price' => $detail->getOrderServiceFee()*$temp['order_group_value'],
                    'order_extra_service_name' => $extraService->getServiceName(),
                    'order_extra_service_listed_price' => $extraService->getServiceListedPrice()*$temp['order_group_value'],
                ];
            }
        }
        if($temp['order_insurrance_fee'] > 0){
            $extraService = ExtraService::findFirstById(VisaExtraService::SERVICE_TRAVEL_INSURANCE);
            if($extraService) {
                $temp['order_extra_services'][] = [
                    'order_extra_service_price' => $temp['order_insurrance_fee']*$temp['order_group_value'],
                    'order_extra_service_name' => $extraService->getServiceName(),
                    'order_extra_service_listed_price' => $extraService->getServiceListedPrice()*$temp['order_group_value'],
                ];
            }
        }
        if($temp['order_4g_sim_card'] > 0){
            $extraService = ExtraService::findFirstById(VisaExtraService::SERVICE_TRAVEL_SIM);
            if($extraService) {
                $temp['order_extra_services'][] = [
                    'order_extra_service_price' => $temp['order_4g_sim_card']*$temp['order_group_value'],
                    'order_extra_service_name' => $extraService->getServiceName(),
                    'order_extra_service_listed_price' => $extraService->getServiceListedPrice()*$temp['order_group_value'],
                ];
            }
        }
        $order_members = OrderMember::findByOrderID($id);
        $temp['order_members'] = [];
        $no =1;
        foreach ($order_members as $member){
            $temp['order_members'][] = [
                'member_no' => $no++,
                'member_id' => $member->getMemberId(),
                'member_name' => $member->getMemberName().' '.$member->getMemberGivenName(),
                'member_nationality' => Country::getNameById($member->getMemberCountryId()),
                'member_birthday' => $this->my->formatDateDMY($member->getMemberBirthday()),
                'member_gender' => OrderMember::getGenderName($member->getMemberGender()),
                'member_passport' => $member->getMemberPassport(),
            ];
        }
        $user = User::findFirstById($temp['order_user_id']);
        if($user){
            $temp['user'] = $user->toArray();
            $temp['user']['user_type'] = UserType::getNameById($user->getUserType());
            $temp['user']['user_country_name'] = CountryGeneral::getCountryNameByCode($user->getUserCountryId());
        }

        $this->view->setVars(array(
            'order' => $temp,
        ));
    }
    public function receiptAction()
    {
        $id = $this->my->getIdFromFormatID($this->dispatcher->getParam('id'));
        $type = $this->dispatcher->getParam('type');
        $receipt_file = '';
        if ($type == 'payment') {
            $payment = Payment::findFirstById($id);
            if (!$payment) goto END;
            if ($payment->getPaymentStatus() != VisaPayment::STATUS_SUCCESS) goto END;
            $receipt_file = $payment->getReceiptFile();
        } else if ($type == 'order') {
            $order = Order::findFirstById($id);
            if (!$order) goto END;
            if ($order->getOrderStatus() != VisaOrder::STATUS_SUCCESS) goto END;
            $receipt_file = $order->getReceiptFile();
        }
        \S3::setAuth(MyS3Key, MyS3Secret);
        $getObjectS3 = \S3::getObject(MyS3Bucket, $receipt_file);
        if (is_object($getObjectS3) && !empty($getObjectS3->body)) {
            $fileName = $this->my->getHrefLastValue($receipt_file);
            $fileType = 'application/pdf';
            $size = $getObjectS3->headers['size'];
            header('Content-Type: ' . $fileType);
            header('Content-Disposition: inline; filename=' . $fileName);
            header('Content-Length: ' . $size);
            echo $getObjectS3->body;
            return false;
        }
        END:
        return $this->response->redirect('notfound');
    }

    public function invoiceAction()
    {
        $id = $this->my->getIdFromFormatID($this->dispatcher->getParam('id'));
        $type = $this->dispatcher->getParam('type');
        $invoice_file = '';
        if ($type == 'payment') {
            $payment = Payment::findFirstById($id);
            if (!$payment) goto END;
            $invoice_file = $payment->getInvoiceFile();
        } else if ($type == 'order') {
            $order = Order::findFirstById($id);
            if (!$order) goto END;
            $invoice_file = $order->getInvoiceFile();
        }
        \S3::setAuth(MyS3Key, MyS3Secret);
        $getObjectS3 = \S3::getObject(MyS3Bucket, $invoice_file);
        if (is_object($getObjectS3) && !empty($getObjectS3->body)) {
            $fileName = $this->my->getHrefLastValue($invoice_file);
            $fileType = 'application/pdf';
            $size = $getObjectS3->headers['size'];
            header('Content-Type: ' . $fileType);
            header('Content-Disposition: inline; filename=' . $fileName);
            header('Content-Length: ' . $size);
            echo $getObjectS3->body;
            return false;
        }
        END:
        return $this->response->redirect('notfound');
    }
}