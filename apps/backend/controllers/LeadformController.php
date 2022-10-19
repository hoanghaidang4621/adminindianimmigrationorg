<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaLeadform;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class LeadformController extends ControllerBase
{
    public function indexAction()
    {
        $data = $this->getParameter();
        $keyword = $this->dispatcher->getParam("txtSearch");
        $from = $this->dispatcher->getParam('txtFrom');
        $to = $this->dispatcher->getParam('txtTo');
        $list_contactus = $this->modelsManager->executeQuery($data['sql'],$data['para']);
        $current_page = $this->request->get('page');
        $validator = new Validator();
        if($validator->validInt($current_page) == false || $current_page < 1)
            $current_page=1;
        $paginator = new PaginatorModel(
            [
                'data'  => $list_contactus,
                'limit' => 20,
                'page'  => $current_page,
            ]
        );

        $this->view->setVars(array(
            'page' => $paginator->getPaginate(),
            'from' => $from,
            'to' => $to,
            'keyword' => $keyword
        ));
    }
    public function viewAction()
    {
        $id = $this->request->get('id');
        $checkID = new Validator();
        if(!$checkID->validInt($id))
        {
            $this->response->redirect('notfound');
            return ;
        }
        $leadform_model = VisaLeadform::findFirstById($id);
        if(empty($leadform_model))
        {
            $this->response->redirect('notfound');
            return;
        }
        $this->view->leadformModel = $leadform_model;
    }
    private function getParameter(){
        $sql = "SELECT * FROM Indianimmigrationorg\Models\VisaLeadform WHERE 1";
        $keyword = trim($this->request->get("txtSearch"));
        $from = trim($this->request->get("txtFrom")); //string
        $to = trim($this->request->get("txtTo"));  //string
        $arrParameter = array();
        $validator = new Validator();
        if(!empty($keyword)) {
            if($validator->validInt($keyword)) {
                $sql.= " AND (leadform_id = :number:)";
                $arrParameter['number'] = $this->my->getIdFromFormatID($keyword, true);
            }
            else {
                $sql.=" AND (leadform_name like CONCAT('%',:keyword:,'%') OR leadform_email like CONCAT('%',:keyword:,'%'))";
                $arrParameter['keyword'] = $keyword;
            }
            $this->dispatcher->setParam("txtSearch", $keyword);
        }
        if($from){
            $intFrom = $this->my->UTCTime(strtotime($from)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND leadform_insert_time >= :from:";
            $arrParameter['from'] = $intFrom;
            $this->dispatcher->setParam("txtFrom", $from);
        }
        if($to){
            $intTo = $this->my->UTCTime(strtotime($to)); //UTC_mysql_time = date_picker - time zone
            $sql .= " AND leadform_insert_time <= :to:";
            $arrParameter['to'] = $intTo;
            $this->dispatcher->setParam("txtTo", $to);
        }
        $sql.=" ORDER BY leadform_insert_time DESC";
        $data['para'] = $arrParameter;
        $data['sql'] = $sql;
        return $data;
    }
}
