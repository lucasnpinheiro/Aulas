<?php

namespace Core;

use Core\Helpers\Helper;
use Core\App;
use Core\Cache;

/**
 * Classe que gerencia as views que serão carregadas no sistema
 * 
 * @author Lucas Pinheiro
 */
class View extends App {

    /**
     *
     * Carrega a classe session
     * 
     * @var object 
     */
    public $session = null;

    /**
     *
     * Carrega a classe helper
     * 
     * @var object 
     */
    public $helpers = null;

    /**
     *
     * Carrega a classe request
     * 
     * @var object 
     */
    public $request = null;

    /**
     *
     * Dados foram gerados pelo controller
     * 
     * @var array 
     */
    public $data = array();

    /**
     * 
     * view que vai ser carregada
     *
     * @var string 
     */
    public $view = '';

    /**
     * 
     * diretorio que contem a view
     *
     * @var string 
     */
    public $dir = '';

    /**
     * 
     * Qual o layout que vai ser carregado no sistema
     *
     * @var string 
     */
    public $layout = 'default';

    /**
     * 
     * O conteudo total carregado para exibir na tela
     *
     * @var string 
     */
    public $conteudo = null;

    /**
     *
     * Define se vai gerar cache dos dados
     * 
     * @var boolean 
     */
    public $cache = false;

    /**
     * 
     * Carrega a classe de cache
     *
     * @var object 
     */
    private $_cache;

    /**
     * 
     * Função de auto execução ao startar a classe.
     * 
     * @param string $view
     * @param string $layout
     */
    public function __construct($view, $layout = 'default') {
        parent::__construct();
        $this->request = new Request();
        $this->session = new Session();
        $this->helpers = new Helper();
        $this->view = $view;
        $this->layout = $layout;
        $this->_cache = new Cache('template' . DS . $layout . DS . $view);
        if ($this->cache != true) {
            $this->_cache->deleteAll();
        }
    }

    /**
     * Carrega os helpers que serão usados no sistema
     */
    public function loads() {
        $lista = $this->helpers->load();
        if (count($lista) > 0) {
            foreach ($lista as $key => $value) {
                $class = 'Core\Helpers\\' . $value['class'];
                $this->{$value['nome']} = new $class;
            }
        }
    }

    /**
     * 
     * exibe a view com os dados já populados
     * 
     * @throws \Exception
     */
    public function render() {
        $v = ROOT . 'src' . DS . 'Template' . DS . $this->dir . DS . $this->view . '.php';
        try {
            if (!file_exists($v)) {
                throw new \Exception('A View "' . $v . '" não localizada.', 500);
            }
            if ($this->cache) {
                $cache = $this->_cache->read($v);
                if (is_null($cache)) {
                    ob_start();
                    extract($this->data);
                    include $v;
                    $cache = ob_get_contents();
                    ob_clean();
                    $this->_cache->save($v, $cache);
                }
                $this->conteudo = $cache;
            } else {
                ob_start();
                extract($this->data);
                include $v;
                $this->conteudo = ob_get_contents();
                ob_clean();
            }
        } catch (\Exception $exc) {
            debug($exc);
        }
    }

    /**
     * 
     * Carrega os layout junto com as views prontas para exibir na tela
     * 
     * @throws MyException
     */
    public function renderlayout() {
        try {

            $v = ROOT . 'src' . DS . 'Template' . DS . 'Layouts' . DS . $this->layout . '.php';
            if (!file_exists($v)) {
                throw new \Exception('O Layout "' . $v . '" não localizado.', 500);
            }
            if ($this->cache) {
                $layout = $this->_cache->read($v);
                if (is_null($layout)) {
                    ob_start();
                    include $v;
                    $layout = ob_get_contents();
                    ob_clean();
                    $this->_cache->save($v, $layout);
                }
            } else {
                ob_start();
                include $v;
                $layout = ob_get_contents();
                ob_clean();
            }
            echo $layout;
        } catch (\Exception $exc) {
            debug($exc);
        }
    }

    /**
     * 
     * Carrega parte de um html para ser usado em mais de uma view ou layout
     * 
     * @param string $view
     * @param array $dados
     * @throws MyException
     */
    public function element($view, array $dados = array()) {
        try {
            $v = ROOT . 'src' . DS . 'Template' . DS . 'Elements' . DS . $view . '.php';
            if (!file_exists($v)) {
                throw new MyException('Elemento não localizada.');
            }
            extract($dados);
            include $v;
        } catch (\Exception $exc) {
            debug($exc);
        }
    }

}
