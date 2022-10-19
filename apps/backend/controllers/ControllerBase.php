<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Repositories\Role;

/**
 * @property \GlobalVariable globalVariable
 * @property \My my
 */
class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected $auth;
    protected $title;
    protected $controllerName;
    public function initialize()
    {
        //current user
        $this->view->auth = $this->auth =  $this->session->get('auth');
        $this->view->title = $this->title;
        $controllerName = $this->dispatcher->getControllerName();
        $this->view->controllerName = $this->controllerName = $controllerName;
        if (isset($this->auth['role'])) {

            $role_function = array();
            if ($this->session->has('action')) {
                $role_function = $this->session->get('action');
            } else {
                $role = Role::getFirstByName($this->auth['role']);
                if ($role) {
                    $role_function = unserialize($role->getRoleFunction());
                    $this->session->set('action', $role_function);
                }
            }
            $this->view->role_function = $role_function;
        }
    }
}
