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

    /**
     *
     * Recebe dados da classe Request
     * 
     * @var object 
     */
    public $request = null;
    private $path = array();
    private $uri = array();
    private $controller = 'home';
    private $action = 'index';

    public function __construct() {
        $this->request = new Request();
        $this->path = $this->request->path;
        $this->uri = $this->request->uri;
    }

    /**
     * Executa as chamadas dos dados referente as informações vido da navegação.
     */
    public function run() {
        //$this->uri = array_merge($this->uri, $this->request->match(implode('/', $this->uri)));
        debug($this->uri);
        if (isset($this->uri[0])) {
            $this->controller = $this->uri[0];
            unset($this->uri[0]);
        }

        if (isset($this->uri[1])) {
            $this->action = $this->toLower($this->uri[1]);
            unset($this->uri[1]);
        }

        $this->request->controller = $this->controller;
        $this->request->action = $this->action;

        if (!isset($this->uri)) {
            $this->uri = array();
        }

        $controller = 'src\Controller\\' . $this->toUpper($this->controller) . 'Controller';
        $class_name = ROOT . str_replace('\\', DS, $controller) . '.php';
        if (!file_exists($class_name)) {
            debug('Controller não localizado.');
        } else {
            $controller = new $controller();
            $action = $this->action;
            call_user_func_array(array($controller, 'beforeController'), $this->uri);
            if (method_exists($controller, $action)) {
                call_user_func_array(array($controller, $action), $this->uri);
            } else if (method_exists($controller, '_remap')) {
                $this->uri[0] = $action;
                ksort($this->uri);
                call_user_func_array(array($controller, '_remap'), $this->uri);
            } else {
                call_user_func_array(array($controller, '_error'), $this->uri);
            }
            call_user_func_array(array($controller, 'afterController'), $this->uri);
            call_user_func_array(array($controller, 'beforeRender'), $this->uri);
            $controller->render();
        }
    }

}
