<?php

namespace Core;

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
    public $controller = 'home';

    /**
     *
     * informa qual o action que deve ser chamado
     * 
     * @var string 
     */
    public $action = 'index';

    public function __construct() {
        $this->_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER["HTTP_HOST"] . '/' . implode('/', array_slice(explode('/', trim($_SERVER["SCRIPT_NAME"], '/')), 0, -2)) . '/';

        $ex = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
        $this->path = array_slice($ex, 0, -2);

        $ex = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->uri = array_slice($ex, count($this->path));
        if (count($this->uri) > 2) {
            $this->controller = $this->uri[0];
            $this->action = $this->uri[1];
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
        $s = self::search($key, $this->data);
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
        $s = self::search($key, $this->query);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    public function url($url = null) {
        $find = preg_match("/(http|https|ftp):\/\/(.*?)$/i", $url, $matches);
        if ($find === 0) {
            return $this->_url . trim($url, '/');
        }
        return $url;
    }

}
