<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaCountry;
use Indianimmigrationorg\Models\VisaCountryFee;
use Indianimmigrationorg\Models\VisaGroupApplicant;
use Indianimmigrationorg\Models\VisaVisaFee;
use Indianimmigrationorg\Models\VisaVisaType;
use Indianimmigrationorg\Repositories\CountryFee;
use Indianimmigrationorg\Repositories\VisaFee;
use Indianimmigrationorg\Repositories\VisaType;

class VisafeeController extends ControllerBase
{

	public function indexAction()
	{
        $type_id = trim($this->request->get("txtTypeID"));
        if($type_id == NULL){
            $type_id = VisaType::getIdDefault();
        }
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $checkType = VisaType::findFirstById($type_id);
        if(empty($checkType)){
            return $this->response->redirect('notfound');
        }
        $list_type_visa = VisaVisaType::find("type_active='Y'");
	    $list_group_applicant = VisaGroupApplicant::find("group_active='Y'");
        $list_country = VisaCountry::find("country_active='Y' AND country_value = 2");
	    $total =0;
        if ($this->request->isPost()) {
            foreach ($list_group_applicant as $group){
                $gaId = $group->getGroupId();
                $fee  = $this->request->get("txtGroup".$gaId);
                $visafee = VisaFee::findFirstById($type_id,$gaId);
                if ($fee != NULL) {
                    if (!$visafee) {
                        $visafee = new VisaVisaFee();
                        $visafee->setVisaTypeId($type_id);
                        $visafee->setGroupId($gaId);
                    }
                    $visafee->setVisaFee($fee);
                    $result = $visafee->save();
                    if($result)$total ++;
                }else{
                    if($visafee){
                        $result = $visafee->delete();
                        if($result) $total ++;
                    }
                }
            }
            foreach ($list_country as $country){
                $countryId = $country->getCountryId();
                $fee  = $this->request->get("txtCountry".$countryId);
                $countryfee = CountryFee::findFirstById($type_id,$countryId);
                if ($fee != NULL) {
                    if (!$countryfee) {
                        $countryfee = new VisaCountryFee();
                        $countryfee->setVisaTypeId($type_id);
                        $countryfee->setCountryId($countryId);
                    }
                    $countryfee->setVisaFee($fee);
                    $result = $countryfee->save();
                    if($result)$total ++;
                }else{
                    if($countryfee){
                        $result = $countryfee->delete();
                        if($result) $total ++;
                    }
                }
            }
            $msg_result['status'] = 'success ';
            $msg_result['msg'] = "Update $total records successfully";
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect('visafee?txtTypeID='.$type_id);
        }
        $this->view->setVars([
            'type_id' => $type_id,
            'list_type_visa' => $list_type_visa,
            'list_group_applicant' => $list_group_applicant,
            'list_country' => $list_country,
            'msg_result' => $msg_result,
        ]);
    }
}