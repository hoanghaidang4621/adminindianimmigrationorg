<?php

namespace Indianimmigrationorg\Backend\Controllers;

class DeletecachetoolController extends ControllerBase
{
    const URL_DELETE_CACHE = 'configCache';
    const URL_DELETE_LOCATION_LANGUAGE_CACHE = 'locationLanguageCache';
    const URL_DELETE_ROUTER_CACHE = 'routerCache';
    const URL_DELETE_PAGE_CACHE = 'pageKey';

    public function indexAction()
    {
        $msg_result = array();
        if ($this->session->has('msg_result')) {
            $msg_result = $this->session->get('msg_result');
            $this->session->remove('msg_result');
        }
        $this->view->setVars([
            'msg_result'=> $msg_result,
            'URL_DELETE_CACHE' => self::URL_DELETE_CACHE,
            'URL_DELETE_LOCATION_LANGUAGE_CACHE' => self::URL_DELETE_LOCATION_LANGUAGE_CACHE,
            'URL_DELETE_ROUTER_CACHE' => self::URL_DELETE_ROUTER_CACHE,
            'URL_DELETE_PAGE_CACHE' => self::URL_DELETE_PAGE_CACHE,
        ]);
    }

    public function deletecacheAction()
    {
        $this->view->disable();
        $btn_delete = $this->request->getPost('delete');
        if ($this->request->isPost()) {
            $urlDelete =  "https://new.indianimmigration.org/";
            $URL_DELETE_CACHE_TOOL = $urlDelete.'/delete-cache';
            $URL_DELETE_CACHE_TOOL .= '?type=' . $btn_delete;
            $result = self::curl_get_contents($URL_DELETE_CACHE_TOOL);
            $this->session->set('msg_result', $result);
            $this->response->redirect("/deletecachetool");
        }
    }


    function curl_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            "ctoken=k3FRQ1U0bYHUVSu6");
        $data = curl_exec($ch);
        curl_close($ch);
        $data_de = json_decode($data,true);
        if($data_de === NULL){
            $data_de= [
                'status'=>'error',
                'message' =>$data." false",
            ];
        }
        return $data_de;
    }
}