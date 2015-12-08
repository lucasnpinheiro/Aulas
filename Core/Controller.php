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
     * @var array Recebe todas os dados que será visualiza na view; 
     */
    private $_data = array();

    public function __construct() {
        $this->request = new Request();
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

    /**
     * 
     * @param string Nome da variavel que será recuperada na View
     * @param object Os dados que serão exibidos na view
     */
    public function set($key, $value = null) {
        $this->_data[$key] = $value;
    }

}
