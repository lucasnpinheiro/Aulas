<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

use Core\Helpers\Helper;
use Core\App;

/**
 * Description of View
 *
 * @author lucas
 */
class View extends App {

    public $session = null;
    public $helpers = null;
    public $request = null;
    public $data = array();
    public $view = '';
    public $dir = '';
    public $layout = 'default';
    public $conteudo = null;

    //put your code here

    public function __construct($view, $layout = 'default') {
        parent::__construct();
        $this->request = new Request();
        $this->session = new Session();
        $this->helpers = new Helper();
        $this->view = $view;
        $this->layout = $layout;
    }

    public function loads() {
        $lista = $this->helpers->load();
        if (count($lista) > 0) {
            foreach ($lista as $key => $value) {
                $class = 'Core\Helpers\\' . $value['class'];
                $this->{$value['nome']} = new $class;
            }
        }
    }

    public function render() {
        $v = ROOT . 'src' . DS . 'Template' . DS . $this->toUpper($this->dir) . DS . $this->view . '.php';
        if (!file_exists($v)) {
            throw new \Exception('View não localizada.', 500);
        }
        ob_start();
        extract($this->data);
        include $v;
        $this->conteudo = ob_get_contents();
        ob_clean();
    }

    public function renderlayout() {
        $v = ROOT . 'src' . DS . 'Template' . DS . 'Layouts' . DS . $this->layout . '.php';
        if (!file_exists($v)) {
            throw new MyException('Layout não localizada.');
        }
        ob_start();
        include $v;
        $layout = ob_get_contents();
        ob_clean();
        echo $layout;
    }

    public function element($view, array $dados = array()) {
        $v = ROOT . 'src' . DS . 'Template' . DS . 'Elements' . DS . $view . '.php';
        if (!file_exists($v)) {
            throw new MyException('Elemento não localizada.');
        }
        extract($dados);
        include $v;
    }

}
