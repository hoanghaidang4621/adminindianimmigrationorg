<?php

namespace Indianimmigrationorg\Utils;

use Phalcon\Crypt;
use Phalcon\Mvc\User\Component;

class PasswordGenerator extends Component
{
    public static function generateStringRandom($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_+<>?,./;:|{}[]';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $data
     * @return string
     */
    public static function encryptData($data)
    {
        $crypt = new Crypt();
        $crypt->setCipher('aes-256-ctr');
        $crypt->useSigning(true);
        $key = "T2\xb1\x88\xe8\xc9\xde\\\x9c\xbe\x54\x19&[\x50\xe8\xa4~Lc1\xbeW\x9b";

        return $crypt->encryptBase64((string)$data, $key);
    }

    public static function decryptData($data)
    {
        try {
            $crypt = new Crypt();
            $crypt->setCipher('aes-256-ctr');
            $crypt->useSigning(true);
            $key = "T2\xb1\x88\xe8\xc9\xde\\\x9c\xbe\x54\x19&[\x50\xe8\xa4~Lc1\xbeW\x9b";
            return $crypt->decryptBase64($data, $key);
        } catch (\Exception $exception) {
            return false;
        }
    }
    public static function decodePass($pass,$salt,$iteration)
    {
        $checkHash = base64_encode(hash_pbkdf2("sha256", $pass, $salt, $iteration, 32, true));
        return $checkHash;

    }
    public function encodePass($pass)
    {
        $passSalt = $this->salt();
        $iteration = 10000; //default in Azerbaijan Immigration Services Teamrp
        $hashPass = "pbkdf2_sha256\$" . $iteration . "\$" . $passSalt . "\$" . base64_encode(hash_pbkdf2("sha256", $pass, $passSalt, $iteration, 32, true));
        return $hashPass;
    }
    public function salt($lenght = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $lenght; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

