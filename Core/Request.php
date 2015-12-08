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

    public $path = array();
    public $uri = array();
    public $data = array();

    //put your code here

    public function __construct() {
        $ex = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $this->path = array_slice($ex, 0, -2);

        $ex = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->uri = array_slice($ex, count($this->path));

        unset($ex);
        $this->data = $_POST;
    }

    public function data($key = null, $default = null) {
        if (is_null($key)) {
            return $this->data;
        }
        if (!isset($this->data[$key])) {
            return $default;
        }
        return $this->data[$key];
    }

}
