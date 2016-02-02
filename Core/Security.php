<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Security
 *
 * @author lucas
 */
class Security {

    //put your code here

    public function crypt($value, $type = 'md5', $options = []) {
        $type = strtolower($type);
        switch ($type) {
            case 'md5':
                return md5($value);
                break;

            case 'crypt':
                return crypt($value);
                break;

            case 'sha1':
                return sha1($value);
                break;

            case 'base64':
                return base64_encode($value);
                break;

            case 'bcrypt':
                $options = array_merge([
                    'cost' => 12,
                        ], $options);
                return password_hash($value, PASSWORD_BCRYPT, $options);
                break;

            default:
                return $value;
                break;
        }
    }

    public function check($value, $type = 'md5', $options = []) {
        $type = strtolower($type);
        switch ($type) {
            case 'bcrypt':
                return (bool) password_verify($value, $crypt);
                break;

            default:
                return $value;
                break;
        }
    }

    public function uncrypt($value, $crypt) {
        $type = strtolower($type);
        switch ($type) {
            case 'base64':
                return base64_decode($value);
                break;


            default:
                return $value;
                break;
        }
    }

}
