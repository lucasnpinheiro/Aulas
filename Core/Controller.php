<?php

namespace Core;

/**
 * Classe basica para o gerenciamento do Controller
 *
 * @author Lucas Pinheiro
 */
class Controller {

    /**
     *
     * Recebe a classe Request 
     * 
     * @var object
     */
    public $request = null;

    /**
     * 
     * Recebe a classe Request 
     *
     * @var object 
     */
    public $session = null;

    /**
     * 
     * Recebe o nome da view que será renderizada os dados. 
     *
     * @var string 
     */
    public $view = null;

    /**
     * 
     * Recebe o layout da estrutura basica que recebera a capa final da visualização 
     *
     * @var string 
     */
    public $layout = 'default';

    /**
     * 
     * Recebe o todos os helper a ser instanciado. 
     *
     * @var array 
     */
    public $helper = [];

    /**
     * 
     * Recebe os erros dos formulario. 
     *
     * @var array 
     */
    public $error = [];

    /**
     * 
     * Faz cache da View.
     *
     * @var boolean
     */
    public $cache = false;

    /**
     * 
     * Recebe todas os dados que será visualiza na view; 
     *
     * @var array 
     */
    private $_data = array();

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        $this->request = new Request();
        $this->session = new Session();
    }

    /**
     * Função que é chamada antes da execução a ação de cada controller
     */
    public function beforeController() {
        
    }

    /**
     * Função que é chamada após a execução do controller principal
     */
    public function afterController() {
        
    }

    /**
     * Função que é antes da exibição dos dados na view
     */
    public function beforeRender() {
        
    }

    /**
     * 
     * Função que renderiza o resultado da visualização dos dados.
     * 
     * @param string
     */
    public function render() {
        if (empty($this->view)) {
            $this->view = $this->request->action;
        }
        $r = new View($this->view, $this->layout, $this->_data);
        $r->dir = $this->request->controller;
        $r->data = $this->_data;
        if (count($this->helper) > 0) {
            foreach ($this->helper as $key => $value) {
                $r->helpers->addHerper($value);
            }
            if (count($this->error) > 0) {
                $r->helpers->Form->error($this->error);
            }
        }

        $r->cache = $this->cache;
        $r->loads();
        $r->render();
        $r->renderlayout();
    }

    /**
     * 
     * Seta a variaveis que serão usadas na view
     * 
     * @param string $key
     * @param string $value
     * @param object
     */
    public function set($key, $value = null) {
        $this->_data[$key] = $value;
    }

    /**
     * 
     * Erro já pré definido
     * 
     */
    public function _error() {
        $this->set('error', 'Action informada não existe.');
        $this->request->controller = 'error';
        $this->view = 'error';
    }

    /**
     * 
     * Carrega uma tabela para o controller
     * 
     * @param type $name
     * @return \Core\Controller
     */
    public function loadTable($name) {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $table = '\src\Model\Table\\' . $table;
        $this->{$name} = new $table();
        return $this;
    }

    public function redirect($url) {
        $url = $this->request->url($url);
        header('location:' . $url);
        exit;
    }

}
