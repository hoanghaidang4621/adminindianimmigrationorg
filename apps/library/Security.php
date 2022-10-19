<?php

use Indianimmigrationorg\Models\VisaRole;
use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Acl;
use Indianimmigrationorg\Repositories\Role;
/**
 * Security
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class Security extends Plugin
{
    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }
    //get Acl
    public function getAcl()
    {
        $acl= new Phalcon\Acl\Adapter\Memory();
        //if (!isset($this->persistent->acl)) {
            $acl->setDefaultAction(Acl::DENY);
            /*Register roles*/
            $guest = new \Phalcon\Acl\Role('guest');
            $acl->addRole($guest);
            $user = new \Phalcon\Acl\Role('user');
            $acl->addRole($user, 'guest');
            $acl->addRole($user);
            $list_role = Role::getAllActive();
            /**
            Register Roles
             */
            foreach($list_role as $role){
                $acl->addRole(new \Phalcon\Acl\Role($role->role_name), 'user');
            }
            //Array Resource for any role
            foreach ($list_role as  $item) {
                $nameResource = $item->role_name;
                $role_function = unserialize($item->role_function);
                foreach ($role_function as $resource => $actions) {
                    $acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
                    $acl->allow($nameResource, $resource, $actions);
                }
            }

            /*Guest resources*/
            $publicResources = array(
                'backendlogin' => array('index', 'login')
            );
            foreach ($publicResources as $resource => $actions) {//$resource is key, $actions is value
                $acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
            }
            /*User resources*/
            $userResources = array();
            foreach ($userResources as $resource => $actions) {//$resource is key, $actions is value
                $acl->addResource(new \Phalcon\Acl\Resource($resource), $actions);
            }

            /*Grant access to public areas to guest, user and editor*/
            foreach ($publicResources as $resource => $actions) {
                $acl->allow('guest', $resource, $actions);
            }
            foreach ($userResources as $resource => $actions) {
                $acl->allow('user', $resource, $actions);
            }
            // Store serialized ACL
            $this->persistent->acl = $acl;
       /*
        }
        else
        {
            //Restore ACL object from serialized ACL
            $acl = $this->persistent->acl;
        }
       */
        return $acl;
    }
    /**
     * This action is executed before execute any action in the application
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        $module = $dispatcher->getModuleName();
        if(!$auth){
            $role = 'guest';
        }
        else if(isset($auth['role'])){
            $role = $auth['role'];
        }
        else{
            $role = 'user';
        }
        if($role == 'user' && $module == 'backend'){
            $this->response->redirect('/');
            return false;
        }
        $module = $dispatcher->getModuleName();
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        $acl = $this->getAcl();
     //   echo $module.$controller.$action ; die();
        $resource = $module.$controller;

        $allowed = $acl->isAllowed($role, $module.$controller, $action);
        if ($allowed != Acl::ALLOW)
        {

            if($acl->isResource($resource))
            {
                if(($module == 'backend') && !in_array($role, VisaRole::getGuestUser())){
                    $this->response->redirect('accessdenied');
                    return false;
                }

                switch($module)
                {
                    default:
                        $this->response->redirect('login');
                        break;
                }
            }
            else{
                $this->session->set('URL_NOTFOUND_SERVER', $_SERVER);
                $this->response->redirect('notfound'); //404 not found
            }
            return false;
        }
    }
}

