<?php

namespace Core;

/**
 * Classe que gerencia arquivos de configurações
 *
 * @author Lucas Pinheiro
 */
class Configure extends App {

    /**
     *
     * Variavel que mantem os dados que foram carregados.
     * 
     * @var type 
     */
    public static $dados = array();

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
        if (file_exists(ROOT . 'Config' . DS . $name . '.php')) {
            include ROOT . 'Config' . DS . $name . '.php';
            self::$dados[$name] = $config;
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
