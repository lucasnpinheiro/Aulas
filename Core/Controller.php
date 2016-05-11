<?php

namespace Core;

/**
 * Classe basica para o gerenciamento do Controller
 *
 * @author Lucas Pinheiro
 */
class Controller {

    use \Core\Traits\FuncoesTrait;

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
    public $Auth = null;

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
     * Faz a redenrização automatica da view.
     *
     * @var string 
     */
    public $autoRender = true;

    /**
     * 
     * Recebe o todos os helper a ser instanciado. 
     *
     * @var array 
     */
    public $helper = [];

    /**
     * 
     * Recebe o todos os helper a ser instanciado. 
     *
     * @var array 
     */
    public $components = [];

    /**
     * 
     * Recebe os erros dos formulario. 
     *
     * @var array 
     */
    public $error = [];

    /**
     * 
     * Recebe os erros dos formulario. 
     *
     * @var array 
     */
    public $pagination = [];

    /**
     * 
     * Recebe todas os dados que será visualiza na view; 
     *
     * @var array 
     */
    private $_data = [];
    protected $_loadModel = [];

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct(Request $request, Session $session, Auth $auth) {
        $this->request = $request;
        $this->session = $session;
        $this->Auth = $auth;
        $this->Auth->init();
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
           
        if (!empty($this->_loadModel)) {
            foreach ($this->_loadModel as $key => $value) {
                $error = $this->{$value}->validacao_error;
                if (!empty($error)) {
                    $this->error = Hash::merge($this->error, $error);
                }
                unset($error);
            }
        }

        $r = new View($this->request, $this->session, new Helpers\Helper($this->request));
        if (empty($this->view)) {
            $this->view = $this->request->action;
        }
        $r->view = $this->view;
        $r->layout = $this->layout;
        //debug($r);
        $dir = '';
        if (count($this->request->path) > 0) {
            foreach ($this->request->path as $key => $value) {
                $dir .= Inflector::camelize($value) . DS;
            }
        }
        $r->dir = $dir . Inflector::camelize(Inflector::underscore($this->request->controller));
        $r->data = $this->_data;
        //debug($this->_data);
        if (count($this->helper) > 0) {
            foreach ($this->helper as $key => $value) {
                $r->helpers->addHerper($value);
            }
        }
        $r->loads();
        if (count($this->helper) > 0) {
            if (count($this->error) > 0) {
                $r->Form->error($this->error);
            }
            if (count($this->pagination) > 0) {
                $r->Pagination->init($this->pagination);
            }
        }
        if ($this->autoRender) {
            $r->render();
        }
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
    public function loadModel($name) {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $this->_loadModel[$name] = $name;
        $table = '\App\Model\Table\\' . $table;
        $this->{$name} = new $table();
        return $this;
    }

    /**
     * 
     * Carrega uma tabela para o controller
     * 
     * @param type $name
     * @return \Core\Controller
     */
    public function loadComponent($name) {
        $component = str_replace('Component', '', $name) . 'Component';
        $name = str_replace('Component', '', $name);
        $files = [
            'Core\Component\\' . $component,
            'App\Controller\Component\\' . $component,
        ];
        foreach ($files as $key => $value) {
            $class_name = ROOT . str_replace('\\', DS, $value) . '.php';
            $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
            if (file_exists($class_name)) {
                $this->{$name} = new $value();
                break;
            }
        }


        return $this;
    }

    public function redirect($url) {
        return $this->request->redirect($url);
    }

    public function referer() {
        return $this->request->referer();
    }

    public function pagination($model, $object, $qtd = 10) {
        $page = (int) $this->request->query('page', 1);
        $object->limit((($page - 1) * $qtd), $qtd);
        $this->set(Inflector::underscore($model), $object->all());
        $this->{$model}->allCount();
        $this->pagination['total'] = (int) $this->{$model}->total_registro;
        $this->pagination['page'] = $page;
        $this->pagination['quantidade'] = (int) $qtd;
    }

}
