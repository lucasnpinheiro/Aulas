<?php

namespace Core;

use Core\Configure;
use Core\Inflector;

/**
 * Classe responsavel pela requisições que recebe o Sistema.
 *
 * @author Lucas Pinheiro
 */
class Request extends App {

    /**
     *
     * Variavel que recebe todos os dados que vem do $_GET
     * 
     * @var array 
     */
    public $query = array();

    /**
     *
     * Variavel que recebe todos os dados que vem da navegação dos diretorios do sistema.
     * 
     * @var array 
     */
    public $path = array();

    /**
     *
     * Variavel que recebe todos os dados que vem da navegação após a identidicação dos diretorios.
     * 
     * @var array 
     */
    public $uri = array();

    /**
     *
     * Variavel que recebe todos os dados que vem da navegação após a identidicação dos diretorios.
     * 
     * @var array 
     */
    private $_url = '';

    /**
     *
     * Variavel que recebe todos os dados que vem do $_POST
     * 
     * @var array 
     */
    public $data = array();

    /**
     *
     * Recebe os dados de parametros do sistema
     * 
     * @var array 
     */
    public $params = array();

    /**
     *
     * informa qual o controller que deve ser chamado
     * 
     * @var string 
     */
    public $controller = 'Home';

    /**
     *
     * informa qual o action que deve ser chamado
     * 
     * @var string 
     */
    public $action = 'index';

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        $this->_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER["HTTP_HOST"] . '/' . implode('/', array_slice(explode('/', trim($_SERVER["SCRIPT_NAME"], '/')), 0, -2)) . '/';
        $ex = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $this->path = array_slice($ex, 0, -2);

        $ex = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $ex[0] = (trim($ex[0]) == '' ? '/' : $ex[0]);
        $this->uri = array_slice($ex, count($this->path));
        $this->match(implode('/', $this->uri));

        if (count($this->uri) > 0) {
            $diretorio_name = ROOT . 'src' . DS . 'Controller';
            $count_indice = 0;
            foreach ($this->uri as $key => $value) {
                $diretorio_name .= DS . Inflector::camelize($value);
                if (is_dir($diretorio_name)) {
                    $count_indice++;
                    $this->path[] = $value;
                }
            }
            $this->uri = array_slice($this->uri, $count_indice);
        }

        if (isset($this->uri[0])) {
            $this->controller = Inflector::camelize($this->uri[0]);
        }
        if (isset($this->uri[1])) {
            $this->action = Inflector::underscore($this->uri[1]);
        }
        if (isset($this->uri[2])) {
            $this->params = array_slice($this->uri, 2);
        }

        unset($ex);
        $this->data = $_POST;
        $this->query = $_GET;
    }

    /**
     * 
     * @param string Chave de navegação
     * @param string Resutado default caso não for achado nenhum resultado referente a navegação
     * @return array|string|null
     */
    public function data($key = null, $default = null) {
        if (is_null($key)) {
            return $this->data;
        }
        $s = self::findArray($key, $this->data);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    /**
     * 
     * @param string Chave de navegação
     * @param string Resutado default caso não for achado nenhum resultado referente a navegação
     * @return array|string|null
     */
    public function query($key = null, $default = null) {
        if (is_null($key)) {
            return $this->query;
        }
        $s = self::findArray($key, $this->query);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    /**
     * 
     * Retorna uma url formatada
     * 
     * @param string $url
     * @return string
     */
    public function url($url = null) {
        $find = preg_match("/(http|https|ftp):\/\/(.*?)$/i", $url, $matches);
        if ($find === 0) {
            return $this->_url . trim($url, '/');
        }
        return $url;
    }

    public function isPost() {
        return (bool) $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function isGet() {
        return (bool) $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isMethod($method) {
        if (!is_array($method)) {
            $method = [$method];
        }
        foreach ($method as $key => $value) {
            if (strtoupper(trim($value)) === $_SERVER['REQUEST_METHOD']) {
                return true;
            }
        }
        return false;
    }

    /**
     * 
     * Faz o tratamento das url para definar os dados de rotas a ser usados.
     * 
     * @param string $uriPath
     */
    public function match($uriPath) {
        $uriPath = '/' . trim($uriPath, '/');
        $c = new Configure();
        $c->load('rotas');
        $rotas = Configure::read('rotas');
        if (count($rotas) > 0) {
            foreach ($rotas as $route => $actualPage) {
                $route_regex = preg_replace('@:[^/]+@', '([^/]+)', $route);
                if (!preg_match('@' . $route_regex . '@', $uriPath, $matches)) {
                    continue;
                }
                $r = preg_match('@' . $route_regex . '@', $route, $identifiers);
                if ($r > 0) {
                    if ($identifiers[0] === $uriPath) {
                        foreach (explode('.', $actualPage) as $k => $v) {
                            $this->uri[$k] = $v;
                        }
                    }
                }
            }
        }
    }

}
