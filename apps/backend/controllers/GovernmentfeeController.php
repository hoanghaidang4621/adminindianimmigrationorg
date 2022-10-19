<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaCountry;
use Indianimmigrationorg\Models\VisaGovernmentFee;
use Indianimmigrationorg\Models\VisaVisaType;;

use Indianimmigrationorg\Repositories\Country;
use Indianimmigrationorg\Repositories\GovernmentFee;
use Indianimmigrationorg\Repositories\VisaType;

class GovernmentfeeController extends ControllerBase
{

	public function indexAction()
	{
        $visa_type_id = trim($this->request->get("slcVisaType"));
        if($visa_type_id == NULL){
            $visa_type_id = VisaType::getIdDefault();
        }
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $checkType = VisaType::findFirstById($visa_type_id);
        if(empty($checkType)){
            return $this->response->redirect('notfound');
        }
        $htmlCountry = Country::getHtml($visa_type_id);
        $list_country = VisaCountry::find("country_active='Y' AND country_value > 0");
	    $total =0;
        if ($this->request->isPost()) {
            foreach ($list_country as $country){
                $countryId = $country->getCountryId();
                $fee  = trim($this->request->get("txtFee".$countryId));
                $note  = trim($this->request->get("txtNote".$countryId));
                $governmentfee = GovernmentFee::findFirstById($visa_type_id,$countryId);
                if ($fee != NULL) {
                    if (!$governmentfee) {
                        $governmentfee = new VisaGovernmentFee();
                        $governmentfee->setFeeVisatypeId($visa_type_id);
                        $governmentfee->setFeeCountryId($countryId);
                    }
                    $governmentfee->setFeeValue($fee);
                    $governmentfee->setFeeNote($note);
                    $result = $governmentfee->save();
                    if($result)$total ++;
                }else{
                    if($governmentfee){
                        $result = $governmentfee->delete();
                        if($result) $total ++;
                    }
                }
            }

            $msg_result['status'] = 'success ';
            $msg_result['msg'] = "Update $total records successfully";
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect('governmentfee?slcVisaType='.$visa_type_id);
        }
        $select_visa_type = VisaType::getCombobox($visa_type_id);
        $this->view->setVars([
            'select_visa_type' => $select_visa_type,
            'html_country' => $htmlCountry,
            'msg_result' => $msg_result,
        ]);
    }
}