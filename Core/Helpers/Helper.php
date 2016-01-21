<?php

namespace Core\Helpers;

use Core\Request;
use Core\Inflector;

/**
 * Classe para gerencial os Helper
 *
 * @author Lucas Pinheiro
 */
class Helper {

    /**
     *
     * Guarda a lista de helper para ser instanciada
     * 
     * @var array
     */
    protected static $_helpers = [];

    /**
     *
     * Variavel que instancia a classe request
     * 
     * @var object 
     */
    public $request = null;

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        $this->request = new Request();
    }

    /**
     * 
     * Adiciona um helper
     * 
     * @param string|array $class
     */
    public function addHerper($class) {
        $default = [
            'nome' => '',
            'class' => '',
        ];

        if (!is_array($class)) {

            $class = [
                'nome' => $class,
                'class' => '',
            ];
        }
        $class = array_merge($default, $class);
        $class['nome'] = Inflector::camelize($class['nome']);
        $class['class'] = Inflector::camelize(str_replace('Helper', '', $class['class'])) . 'Helper';
        self::$_helpers[$class['nome']] = $class;
    }

    /**
     * 
     * instacia os helpers
     * 
     * @return array
     */
    public function load() {
        return self::$_helpers;
    }

    /**
     * 
     * Padroniza o nome
     * 
     * @param string $name
     * @param string|null $prefix
     * @return string
     */
    public function getName($name, $prefix = null) {
        if (!is_null($prefix)) {
            return Inflector::underscore($prefix . $name);
        }
        return Inflector::underscore($name);
    }

    /**
     * 
     * Padroniza o id
     * 
     * @param string $name
     * @param string|null $prefix
     * @return string
     */
    public function getId($name, $prefix = null) {
        if (!is_null($prefix)) {
            return Inflector::parameterize($prefix . '-' . $name);
        }
        return Inflector::parameterize($name);
    }

    /**
     * 
     * faz uma verificação entre os dois array e retorna as chaves do que esta diferente.
     * 
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public function extracao($array1, $array2) {
        return array_diff_key(array_diff_key($array1, $array2), $array2);
    }

}
