<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaFastTrackFee;
use Indianimmigrationorg\Models\VisaGroupApplicant;
use Indianimmigrationorg\Models\VisaPort;
use Indianimmigrationorg\Repositories\FastTrackFee;
use Indianimmigrationorg\Repositories\Port;

class FasttrackfeeController extends ControllerBase
{

	public function indexAction()
	{
        $port_id = trim($this->request->get("txtPortID"));
        if($port_id == NULL){
            $port_id = Port::getIdDefault();
        }
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $checkType = Port::findFirstById($port_id);
        if(empty($checkType)){
            return $this->response->redirect('notfound');
        }
        $list_port = VisaPort::find("port_active='Y'");
	    $list_group_applicant = VisaGroupApplicant::find("group_active='Y'");
	    $total =0;
        if ($this->request->isPost()) {
            foreach ($list_group_applicant as $group){
                $gaId = $group->getGroupId();
                $fee  = $this->request->get("txtGroup".$gaId);
                $fasttrackfee = FastTrackFee::findFirstById($port_id,$gaId);
                if ($fee != NULL) {
                    if (!$fasttrackfee) {
                        $fasttrackfee = new VisaFastTrackFee();
                        $fasttrackfee->setPortId($port_id);
                        $fasttrackfee->setGroupId($gaId);
                    }
                    $fasttrackfee->setFastCheckFee($fee);
                    $result = $fasttrackfee->save();
                    if($result)$total ++;
                }else{
                    if($fasttrackfee){
                        $result = $fasttrackfee->delete();
                        if($result) $total ++;
                    }
                }
            }

            $msg_result['status'] = 'success ';
            $msg_result['msg'] = "Update $total records successfully";
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect('fasttrackfee?txtPortID='.$port_id);
        }
        $this->view->setVars([
            'port_id' => $port_id,
            'list_port' => $list_port,
            'list_group_applicant' => $list_group_applicant,
            'msg_result' => $msg_result,
        ]);
    }
}