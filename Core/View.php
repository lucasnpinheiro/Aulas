<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of View
 *
 * @author lucas
 */
class View extends App {

    public $data = array();
    public $view = '';
    public $dir = '';
    public $layout = 'default';
    public $conteudo = null;
    public $setRender = array(
        'file' => '',
        'conteudo' => '',
        'title' => 'Meu Titulo',
        'meta' => '',
        'css' => '',
        'script' => '',
    );

    //put your code here

    public function __construct($view, $layout = 'default') {
        $this->view = $view;
        $this->layout = $layout;
    }

    public function render() {
        $v = ROOT . 'src' . DS . 'Template' . DS . $this->toUpper($this->dir) . DS . $this->view . '.php';
        if (!file_exists($v)) {
            throw new MyException('View não localizada.');
        }
        ob_start();
        extract($this->data);
        include $v;
        $this->setRender['conteudo'] = ob_get_contents();
        ob_clean();
    }

    public function renderlayout() {
        $v = ROOT . 'src' . DS . 'Template' . DS . 'Layouts' . DS . $this->layout . '.php';
        if (!file_exists($v)) {
            throw new MyException('Layout não localizada.');
        }
        ob_start();
        extract($this->setRender);
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
