<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

use Core\Security;
use Core\Session;
use Core\Configure;

/**
 * Description of Auth
 *
 * @author lucas
 */
class Auth {

    //put your code here

    protected $keyName = 'Auth.User';
    protected $model = null;
    protected $config = 'default';
    protected $default = [
        'model' => '',
        'keyName' => 'Auth.User',
        'crypt' => 'md5',
        'params' => [
            'email' => 'email',
            'password' => 'password'
        ],
        'redirect' => [
            'success' => '',
            'error' => ''
        ],
    ];

    public function __construct() {
        Configure::load('auth');
    }

    public function setConfig($config = 'default') {
        $this->config = $config;
        $this->init();
    }

    public function init(array $options = []) {
        $this->default = array_merge($this->default, Configure::read('auth.' . $this->config), $options);
        $table = '\App\Model\Table\\' . $this->default['model'] . 'Table';
        $this->model = new $table();
        $this->keyName = $this->default['keyName'];
    }

    public function login($dados = []) {
        if (isset($dados[$this->default['params']['email']]) and isset($dados[$this->default['params']['password']])) {
            return $this->find($dados[$this->default['params']['email']], $dados[$this->default['params']['password']]);
        } elseif (isset($dados[$this->default['params']['email']])) {
            return $this->find($dados[$this->default['params']['email']]);
        }
        return false;
    }

    protected function find($email, $password = null) {
        Session::delete($this->keyName);
        $find = $this->model->where($this->default['params']['email'], $email);
        if (!is_null($password)) {
            $s = new Security();
            $password = $s->crypt($password, $this->default['crypt']);
            $find = $find->where($this->default['params']['password'], $password);
        }
        $result = $find->find();
        if (!empty($result)) {
            $result = json_decode(json_encode($result), true);
            Session::write($this->keyName, $result);
            return true;
        }
        return false;
    }

    public function check() {
        $r = Session::read($this->keyName, false);
        if (!empty($r)) {
            return true;
        }
        return false;
    }

    public function user($field = null) {
        if ($this->check()) {
            $r = $this->keyName . (!is_null($field) ? '.' . trim($field, '.') : '');
            return Session::read($r, null);
        }
        return null;
    }

}
