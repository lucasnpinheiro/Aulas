<?php

namespace Core;

/**
 * Classe para garregar o idioma informado.
 *
 * @author Lucas Pinheiro
 */
class Language extends App {

    /**
     *
     * Variavel statica para salvar os dados carregados pela classe
     * 
     * @var array 
     */
    public static $dados = array();

    /**
     *
     * Defina qual é o idioma a ser carregado
     * 
     * @var string 
     */
    public $idioma = 'pt_BR';

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * Os arquivos a ser carregado na memoria.
     * 
     * @param string $name
     */
    public function load($name) {
        if (file_exists(ROOT . 'Language' . DS . $this->idioma . DS . $name . '.php')) {
            require_once ROOT . 'Language' . DS . $this->idioma . DS . $name . '.php';
            self::$dados[$name] = $lang;
        }
    }

    /**
     * 
     * Consulta uma chave do arquivo.
     * 
     * @param string|array $key
     * @return array|string
     */
    public static function read($key) {
        return self::findArray($key, self::$dados);
    }

    /**
     * 
     * Adiciona um item na chave.
     * 
     * @param string|array $key
     * @param string|array $value
     * @return array|string
     */
    public static function write($key, $value) {
        return self::$dados[$key] = $value;
    }

}
