<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaCarFee;
use Indianimmigrationorg\Models\VisaCar;
use Indianimmigrationorg\Models\VisaPort;
use Indianimmigrationorg\Repositories\CarPickupFee;
use Indianimmigrationorg\Repositories\Port;

class CarPickupfeeController extends ControllerBase
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
	    $list_car = VisaCar::find("car_active='Y'");
	    $total =0;
        if ($this->request->isPost()) {
            foreach ($list_car as $car){
                $carId = $car->getCarId();
                $fee  = $this->request->get("txtCar".$carId);
                $carpickupfee = CarPickupFee::findFirstById($port_id,$carId);
                if ($fee != NULL) {
                    if (!$carpickupfee) {
                        $carpickupfee = new VisaCarFee();
                        $carpickupfee->setPortId($port_id);
                        $carpickupfee->setCarId($carId);
                    }
                    $carpickupfee->setCarFee($fee);
                    $result = $carpickupfee->save();
                    if($result)$total ++;
                }else{
                    if($carpickupfee){
                        $result = $carpickupfee->delete();
                        if($result) $total ++;
                    }
                }
            }

            $msg_result['status'] = 'success ';
            $msg_result['msg'] = "Update $total records successfully";
            $this->session->set('msg_result', $msg_result);
            return $this->response->redirect('carpickupfee?txtPortID='.$port_id);
        }
        $this->view->setVars([
            'port_id' => $port_id,
            'list_port' => $list_port,
            'list_car' => $list_car,
            'msg_result' => $msg_result,
        ]);
    }
}