<?php

namespace Indianimmigrationorg\Backend\Controllers;

use Indianimmigrationorg\Models\VisaRole;
use Indianimmigrationorg\Repositories\UserSiteInfoCorp;
use Visacorp\Models\UserCorp;
use Indianimmigrationorg\Utils\Validator;
use Phalcon\Mvc\View;
use Indianimmigrationorg\Repositories\User;

class LoginController extends ControllerBase
{
    public function indexAction()
    {
        if ($this->session->has('auth')) {
            $this->response->redirect('/');
            return;
        }
        if ($this->session->has('msg_login')) {
            $this->view->msg_login = $this->session->get('msg_login');
            $this->session->remove('msg_login');
        }
        if ($this->request->isPost()) {

            $validate = new Validator();
            $email = trim($this->request->getPost('email'));
            $password = trim($this->request->getPost('password'));
            $this->view->email = $email;
            $this->view->password = $password;

            $validLogin = true;
            if (strlen($email) < 1) {
                $this->view->msgErrorEmail = "This field cannot be empty.";
                $validLogin = false;
            } else if (strlen($email) > 255 || !$validate->validEmail($email)) {
                $this->view->msgErrorEmail = "Enter a valid email";
                $validLogin = false;
            } else {
                $this->view->msgErrorEmail = "";
            }
            if (strlen($password) < 1 || strlen($password) > 255) {
                $this->view->msgErrorPass = "This field cannot be empty.";
                $validLogin = false;
            } else {
                $this->view->msgErrorPass = "";
            }

            if ($validLogin) {
                $user = User::findFirstByEmail($email);
                if ($user) {
                    $role = VisaRole::getFirstLoginById($user->getUserRole());
                    $controllerClass = $this->dispatcher->getControllerClass();
                    if (($role) || (strpos($controllerClass, 'Frontend') !== false)) {
                        if (User::checkPass($user->getUserPassword(),$password)) {
                            $user_repo = new User();
                            $user_repo->initSession($user, $role);
                            UserSiteInfoCorp::insertUserSiteInfo($user->getUserId(),$this->globalVariable->site_id);
                            $user_repo->redirectLogged("/");
                            return;
                        } else {
                            $this->view->msgErrorLogin = "Email or password not correct";
                        }
                    } else {
                        $this->view->msgErrorLogin = "User not granted permissions";
                    }
                } else {
                    $this->view->msgErrorLogin = "Email or password not correct";
                }
            }
        }
        $this->view->disableLevel(array(
            View::LEVEL_LAYOUT => false,
            View::LEVEL_MAIN_LAYOUT => false
        ));
        $this->tag->setTitle('Login');
        $this->view->pick('login/index');
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('login');
        return;
    }
}