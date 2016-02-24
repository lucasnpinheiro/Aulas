<?php

namespace Core;


/**
 * Classe que gerencia as views que serão carregadas no sistema
 * 
 * @author Lucas Pinheiro
 */
class View {

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
    public $data = [];

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
     * Função de auto execução ao startar a classe.
     * 
     * @param string $view
     * @param string $layout
     */
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Helpers\Helper $helper) {
        $this->request = $request;
        $this->session = $session;
        $this->helpers = $helper;
    }

    /**
     * Carrega os helpers que serão usados no sistema
     */
    public function loads() {
        $lista = $this->helpers->load();
        if (count($lista) > 0) {
            foreach ($lista as $key => $value) {
                $exist = false;
                $class = 'Core\Helpers\\' . $value['class'];
                $class_name = ROOT . str_replace('\\', DS, $class) . '.php';
                $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
                if (file_exists($class_name)) {
                    $exist = true;
                } else {
                    $class = 'App\Helpers\\' . $value['class'];
                    $class_name = ROOT . str_replace('\\', DS, $class) . '.php';
                    $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
                    if (file_exists($class_name)) {
                        $exist = true;
                    }
                }
                if ($exist === true) {
                    $this->{$value['nome']} = new $class($this->request);
                } else {
                    throw new Exception('Helper não localizado.');
                }
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
            ob_start();
            extract($this->data);
            include $v;
            $this->conteudo = ob_get_contents();
            ob_clean();
        } catch (\Exception $exception) {
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
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
            if (Configure::read('app.sanitize_output')) {
                ob_start('sanitize_output');
            } else {
                ob_start();
            }
            extract($this->data);
            include $v;
            $layout = ob_get_contents();
            ob_clean();
            echo $layout;
        } catch (\Exception $exception) {
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
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
    public function element($view, array $dados = []) {
        try {
            $v = ROOT . 'src' . DS . 'Template' . DS . 'Elements' . DS . $view . '.php';
            if (!file_exists($v)) {
                throw new MyException('Elemento "' . $v . '" não localizada.');
            }
            extract($dados);
            include $v;
        } catch (\Exception $exception) {
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
        }
    }

    public function flash() {
        $s = new Session();
        $d = $s->getFlash();
        if (!empty($d)) {
            return $this->element('Flash/' . $d['type'], $d);
        }
        return null;
    }

}
