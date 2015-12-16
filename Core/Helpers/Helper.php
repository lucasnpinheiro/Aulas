<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Helper
 *
 * @author lucas
 */

namespace Core\Helpers;

use \Core\App;
use Core\Request;
use Core\Inflector;

class Helper extends App {

    //put your code here

    protected static $_helpers = [];
    public $request = null;

    public function __construct() {
        parent::__construct();
        $this->request = new Request();
    }

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

    public function load() {
        return self::$_helpers;
    }

    public function getName($name, $prefix = null) {
        if (!is_null($prefix)) {
            return Inflector::camelize($prefix . ' ' . $name);
        }
        return Inflector::camelize($name);
    }

    public function getId($name, $prefix = null) {
        if (!is_null($prefix)) {
            return Inflector::parameterize($prefix . '-' . $name);
        }
        return Inflector::parameterize($name);
    }
    
    public function extracao($array1, $array2){
        $array3 = array_diff_key($array1, $array2);
        return array_diff_key($array3, $array2);
    }

}
