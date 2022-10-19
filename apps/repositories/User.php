<?php

namespace Indianimmigrationorg\Repositories;

use Indianimmigrationorg\Utils\PasswordGenerator;
use Phalcon\Mvc\User\Component;
use Visacorp\Models\UserCorp;

class User extends Component
{

    public function initSession($user, $role)
    {
        if ($user) {
            $role_name = ($role) ? $role->getRoleName() : "user";
            $this->session->set('auth', array(
                'id' => $user->getUserId(),
                'name' => $user->getUserName(),
                'email' => $user->getUserEmail(),
                'role' => $role_name,
                'insertTime' => $user->getUserInsertTime(),
            ));
        }
        return false;
    }

    public function redirectLogged($pre = "")
    {
        if ($this->session->has('preURL')) {
            $preURL = $this->session->get('preURL');
            $this->session->remove('preURL');
            if (strlen($preURL) > 1 && $preURL != "/") {
                $this->response->redirect($preURL);
                return;
            }
        }
        if ($pre === "") {
            $this->response->redirect("my-account");
        }else {
            $this->response->redirect($pre);
        }
    }
    public static function checkPass($password,$passwordPost){

        $passArray = explode("$", $password);
        if (isset($passArray[0]) && isset($passArray[1]) && isset($passArray[2])&& isset($passArray[3])) {
            $auth_pass = $passArray[3];
            $salt = $passArray[2];
            $iteration = $passArray[1];
            $passwordGenerator = new PasswordGenerator();
            $hash_pass = $passwordGenerator->decodePass($passwordPost, $salt, $iteration);
            if ($auth_pass == $hash_pass) {
                return true;
            }
        }
        return false;
    }
    public static function findFirstByEmail($email)
    {
        return UserCorp::findFirst(array(
            'user_email = :user_email: AND user_active="Y"',
            'bind' => array('user_email' => $email)
        ));
    }
    public  static function findFirstById($id){
        return UserCorp::findFirst(array(
            'user_id = :user_id: ',
            'bind' => array('user_id' => $id)
        ));
    }
    public static function getNameById($id){
        $user = self::findFirstById($id);
        return ($user)?$user->getUserName():'';
    }
}

