<?php

namespace Core;

use Core\Inflector;
use Core\Session;
use Core\Request;
use Core\Auth;

/**
 * Classe que gerencia a rota do sistema
 *
 * @author Lucas Pinheiro
 */
class Router {

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
    private $path = [];

    /**
     *
     * Define as urls do sistema
     * 
     * @var array 
     */
    private $uri = [];

    /**
     * Controller default a ser carregado
     *
     * @var string 
     */
    private $controller = 'Home';

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
    public function __construct(Request $request) {
        $this->request = $request;
        $this->path = $this->request->path;
        $this->uri = $this->request->uri;
    }

    /**
     * Executa as chamadas dos dados referente as informações vido da navegação.
     */
    public function run() {
        $this->controller = $this->request->controller;
        $this->action = $this->request->action;

        if (!isset($this->uri)) {
            $this->uri = [];
        } else {
            $this->uri = array_slice($this->uri, 2);
        }

        $path = '';
        if (count($this->path) > 0) {
            $path = implode('\\', $this->path);
            if (trim($path) != '') {
                $path = Inflector::camelize($path) . '\\';
            }
        }
        $controller = 'App\Controller\\' . $path . $this->controller . 'Controller';
        $class_name = ROOT . str_replace('\\', DS, $controller) . '.php';
        $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
        if (!file_exists($class_name)) {
            $ex = new \Core\MyException();
            $ex->layout = 'default';
            $ex->show_404('pagina não localizada.');
        } else {
            $controller = new $controller($this->request, new Session(), new Auth());
            $action = $this->action;
            call_user_func_array([$controller, 'beforeController'], $this->uri);
            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $this->uri);
            } else {
                call_user_func_array([$controller, '_error'], $this->uri);
            }
            call_user_func_array([$controller, 'afterController'], $this->uri);
            call_user_func_array([$controller, 'beforeRender'], $this->uri);
            $controller->render();
        }
    }

}
