<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Controller
 *
 * @author lucas
 */
class Controller {

    //put your code here
    public $request = null;
    public $view = null;
    public $layout = 'default';
    private $_data = array();

    public function __construct() {
        $this->request = new Request();
    }

    public function beforeFilter() {
        
    }

    public function afterFilter() {
        
    }

    public function render($view = null) {
        if (!is_null($view)) {
            $this->view = $view;
        }
        if (empty($this->view)) {
            $this->view = $this->request->action;
        }
        $r = new View($this->view, $this->layout, $this->_data);
        $r->dir = $this->request->controller;
        $r->data = $this->_data;
        $r->render();
        $r->renderlayout();
    }

    public function set($key, $value = null) {
        $this->_data[$key] = $value;
    }

}
