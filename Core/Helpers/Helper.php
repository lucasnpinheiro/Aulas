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

    use \Core\Traits\FuncoesTrait;
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
    public function __construct(\Core\Request $request) {
        $this->request = $request;
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
        $class = \Core\Hash::merge($default, $class);
        $class['nome'] = Inflector::camelize(Inflector::underscore($class['nome']));
        $class['class'] = Inflector::camelize(Inflector::underscore(str_replace('Helper', '', $class['class']))) . 'Helper';
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
            $name = Inflector::underscore($prefix . $name);
        }
        $name = Inflector::underscore($name);
        return str_replace('-', '_', $name);
    }

    /**
     * 
     * Padroniza o nome
     * 
     * @param string $name
     * @param string|null $prefix
     * @return string
     */
    public function getNameChave($name) {
        $ex = explode('.', $name);
        foreach ($ex as $key => $value) {
            $ex[$key] = str_replace('-', '_', Inflector::underscore($value));
        }
        $index = $ex[0];
        unset($ex[0]);
        $name = '';
        if (!empty($ex)) {
            $name = '[' . implode('][', $ex) . ']';
        }
        return $index . $name;
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
            $name = Inflector::parameterize($prefix . '-' . $name);
        }
        $name = Inflector::parameterize($name);
        return str_replace('_', '-', $name);
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
