<?php

namespace Core;
use Core\Inflector;
/**
 * Classe que gerencia a rota do sistema
 *
 * @author Lucas Pinheiro
 */
class Router extends App {

    /**
     *
     * Recebe dados da classe Request
     * 
     * @var object 
     */
    public $request = null;

    /**
     *
     * Define o path do sistema
     * 
     * @var array 
     */
    private $path = array();

    /**
     *
     * Define as urls do sistema
     * 
     * @var array 
     */
    private $uri = array();

    /**
     * Controller default a ser carregado
     *
     * @var string 
     */
    private $controller = 'home';

    /**
     * Ação default a ser carregado
     *
     * @var string 
     */
    private $action = 'index';

    /**
     * 
     * Função de auto execução ao startar a classe.
     * 
     */
    public function __construct() {
        $this->request = new Request();
        $this->path = $this->request->path;
        $this->uri = $this->request->uri;
    }

    /**
     * Executa as chamadas dos dados referente as informações vido da navegação.
     */
    public function run() {
        if (isset($this->uri[0])) {
            $this->controller = $this->uri[0];
            unset($this->uri[0]);
        }

        if (isset($this->uri[1])) {
            $this->action = Inflector::underscore($this->uri[1]);
            unset($this->uri[1]);
        }
        
        $this->request->controller = $this->controller;
        $this->request->action = $this->action;

        if (!isset($this->uri)) {
            $this->uri = array();
        }

        $controller = 'src\Controller\\' . Inflector::camelize($this->controller) . 'Controller';
        $class_name = ROOT . str_replace('\\', DS, $controller) . '.php';
        if (!file_exists($class_name)) {
            debug('Controller não localizado.');
        } else {
            $controller = new $controller();
            $action = $this->action;
            call_user_func_array(array($controller, 'beforeController'), array($this->uri));
            if (method_exists($controller, $action)) {
                call_user_func_array(array($controller, $action), array($this->uri));
            } else if (method_exists($controller, '_remap')) {
                $this->uri[0] = $action;
                ksort($this->uri);
                call_user_func_array(array($controller, '_remap'), array($this->uri));
            } else {
                call_user_func_array(array($controller, '_error'), array($this->uri));
            }
            call_user_func_array(array($controller, 'afterController'), array($this->uri));
            call_user_func_array(array($controller, 'beforeRender'), array($this->uri));
            $controller->render();
        }
    }

}
