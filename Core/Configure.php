<?php

namespace Core;

/**
 * Classe que gerencia arquivos de configurações
 *
 * @author Lucas Pinheiro
 */
class Configure {

    use Traits\AppTrait;

    /**
     *
     * Variavel que mantem os dados que foram carregados.
     * 
     * @var type 
     */
    public static $dados = [];

    /**
     * 
     * Os arquivos a ser carregado na memoria.
     * 
     * @param string $name
     */
    public static function load($name) {
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
    public static function read($key = NULL) {
        if (empty($key)) {
            return self::$dados;
        }
        $key = trim($key, '.');
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
        $key = trim($key, '.');
        self::$dados = array_merge_recursive(self::$dados, self::setFindArray($key, $value));
    }

}
