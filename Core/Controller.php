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
     * @var object Recebe a classe Request 
     */
    public $request = null;

    /**
     *
     * @var object Recebe a classe Request 
     */
    public $session = null;

    /**
     *
     * @var string Recebe o nome da view que será renderizada os dados. 
     */
    public $view = null;

    /**
     *
     * @var string Recebe o layout da estrutura basica que recebera a capa final da visualização 
     */
    public $layout = 'default';

    /**
     *
     * @var string Recebe o todos os helper a ser instanciado. 
     */
    public $helper = [];

    /**
     *
     * @var recebe os erros dos formulario. 
     */
    public $error = [];

    /**
     *
     * @var array Recebe todas os dados que será visualiza na view; 
     */
    private $_data = array();

    public function __construct() {
        $this->request = new Request();
        $this->session = new Session();
    }

    /**
     * Função que é chamada antes da execução de cada controller
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
     * @param string recebe o nome da view que irá exibir o conteudo
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

        $r->loads();
        $r->render();
        $r->renderlayout();
    }

    /**
     * 
     * @param string Nome da variavel que será recuperada na View
     * @param object Os dados que serão exibidos na view
     */
    public function set($key, $value = null) {
        $this->_data[$key] = $value;
    }

    public function _error() {
        $this->set('error', 'Action informada não existe.');
        $this->request->controller = 'error';
        $this->view = 'error';
    }

    public function loadTable($name) {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $table = '\src\Model\Table\\' . $table;
        $this->{$name} = new $table();
        return $this;
    }

}
