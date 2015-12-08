<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Request
 *
 * @author lucas
 */
class Request {

    public $query = array();
    public $path = array();
    public $uri = array();
    public $data = array();
    public $params = array();
    public $controller = 'home';
    public $action = 'index';

    //put your code here

    public function __construct() {
        $ex = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $this->path = array_slice($ex, 0, -2);

        $ex = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->uri = array_slice($ex, count($this->path));
        if (count($this->uri) > 2) {
            $this->controller = $this->uri[0];
            $this->action = $this->uri[1];
            $this->params = array_slice($this->uri, 2);
        }

        unset($ex);
        $this->data = $_POST;
        $this->query = $_GET;
    }

    public function data($key = null, $default = null) {
        if (is_null($key)) {
            return $this->data;
        }
        $s = $this->search($key, $this->data);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    public function query($key = null, $default = null) {
        if (is_null($key)) {
            return $this->query;
        }
        $s = $this->search($key, $this->query);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    private function search($key, $dados) {
        $s = explode('.', $key);
        $t = count($s) - 1;
        foreach ($s as $k => $v) {
            if (isset($dados[$v])) {
                if ($k === $t) {
                    return $dados[$v];
                }
                $dados = $dados[$v];
            }
        }
        return null;
    }

}
