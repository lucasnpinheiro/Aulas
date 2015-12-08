<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author lucas
 */

namespace Core;

class Router extends App {

    public $request = null;
    private $path = array();
    private $uri = array();
    private $controller = 'home';
    private $action = 'index';

    //put your code here

    public function __construct() {
        $this->request = new Request();
        $this->path = $this->request->path;
        $this->uri = $this->request->uri;
    }

    public function run() {
        if (isset($this->uri[0])) {
            $this->controller = $this->uri[0];
            unset($this->uri[0]);
        }

        if (isset($this->uri[1])) {
            $this->action = $this->toLower($this->uri[1]);
            unset($this->uri[1]);
        }

        if (!isset($this->uri)) {
            $this->uri = array();
        }

        $controller = 'src\Controller\\' . $this->toUpper($this->controller) . 'Controller';
        $controller = new $controller();
        $action = $this->action;
        call_user_func_array(array($controller, 'beforeFilter'), array($this->uri));
        if (method_exists($controller, $action)) {
            call_user_func_array(array($controller, $action), array($this->uri));
        } else if (method_exists($controller, '_remap')) {
            $this->uri[0] = $action;
            ksort($this->uri);
            call_user_func_array(array($controller, '_remap'), array($this->uri));
        }
        call_user_func_array(array($controller, 'afterFilter'), array($this->uri));
        call_user_func_array(array($controller, 'render'), array($this->uri));
    }

}
