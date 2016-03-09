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
        'where' => [
        ]
    ];
    private $session = null;

    public function __construct() {
        Configure::load('auth');
        $this->session = new Session();
    }

    public function setConfig($config = 'default') {
        $this->config = $config;
        $this->init();
    }

    public function init(array $options = []) {
        $this->default = array_merge($this->default, Configure::read('auth.' . $this->config));
        $this->default = Hash::merge($this->default, $options);
        $table = '\App\Model\Table\\' . $this->default['model'] . 'Table';
        $this->model = new $table();
        $this->keyName = $this->default['keyName'];
    }

    public function login($dados = []) {
        $this->session->delete($this->keyName);
        if (isset($dados[$this->default['params']['email']]) and isset($dados[$this->default['params']['password']])) {
            $retorno = $this->find($dados[$this->default['params']['email']], $dados[$this->default['params']['password']]);
        } elseif (isset($dados[$this->default['params']['email']])) {
            $retorno = $this->find($dados[$this->default['params']['email']]);
        }
        if (!empty($retorno)) {
            $this->write($retorno);
            return true;
        }
        return false;
    }

    protected function find($email, $password = null) {
        $find = $this->model->where($this->default['params']['email'], $email);
        if (!is_null($password)) {
            $s = new Security();
            $password = $s->crypt($password, $this->default['crypt']);
            $find->where($this->default['params']['password'], $password);
        }

        if (!empty($this->default['where'])) {
            foreach ($this->default['where'] as $key => $value) {
                switch (count($value)) {
                    case 4:
                        $find->where($value[0], $value[1], $value[2], $value[3]);
                        break;
                    case 3:
                        $find->where($value[0], $value[1], $value[2]);
                        break;

                    default:
                        $find->where($value[0], $value[1]);
                        break;
                }
            }
        }
        return $find->find();
    }

    private function write($result) {
        $result = json_decode(json_encode($result), true);
        $this->session->write($this->keyName, $result);
    }

    public function check() {
        $r = $this->session->read($this->keyName, false);
        if (!empty($r)) {
            if (!empty($this->find($r[$this->default['params']['email']]))) {
                return true;
            }
        }
        return false;
    }

    public function user($field = null) {
        if ($this->check()) {
            $r = $this->keyName . (!is_null($field) ? '.' . trim($field, '.') : '');
            return $this->session->read($r, null);
        }
        return null;
    }

}
