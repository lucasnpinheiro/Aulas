<?php

namespace Core;

use Core\Inflector;

/**
 * Classe que gerencia a rota do sistema
 *
 * @author Lucas Pinheiro
 */
class Router extends App
{

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
    public function __construct()
    {
        $this->request = new Request();
        $this->path = $this->request->path;
        $this->uri = $this->request->uri;
    }

    /**
     * Executa as chamadas dos dados referente as informações vido da navegação.
     */
    public function run()
    {
        $this->controller = $this->request->controller;
        $this->action = $this->request->action;

        if (!isset($this->uri))
        {
            $this->uri = array();
        }

        $path = '';
        if (count($this->path) > 1)
        {
            $path = implode('\\', $this->path);
            if (trim($path) != '')
            {
                $path = Inflector::camelize($path) . '\\';
            }
        }
        $controller = 'App\Controller\\' . $path . $this->controller . 'Controller';
        $class_name = ROOT . str_replace('\\', DS, $controller) . '.php';
        $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
        if (!file_exists($class_name))
        {
            debug('Controller não localizado.');
        } else
        {
            $controller = new $controller();
            $action = $this->action;
            call_user_func_array(array($controller, 'beforeController'), array($this->uri));
            if (method_exists($controller, $action))
            {
                call_user_func_array(array($controller, $action), array($this->uri));
            } else if (method_exists($controller, '_remap'))
            {
                $this->uri[0] = $action;
                ksort($this->uri);
                call_user_func_array(array($controller, '_remap'), array($this->uri));
            } else
            {
                call_user_func_array(array($controller, '_error'), array($this->uri));
            }
            call_user_func_array(array($controller, 'afterController'), array($this->uri));
            call_user_func_array(array($controller, 'beforeRender'), array($this->uri));
            $controller->render();
        }
    }

}
