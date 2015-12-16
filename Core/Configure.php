<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Configure
 *
 * @author lucas
 */
class Configure extends App {

    public static $dados = array();

    public function __construct() {
        parent::__construct();
    }

    public function load($name) {
        if (file_exists(ROOT . 'Config' . DS . $name . '.php')) {
            require_once ROOT . 'Config' . DS . $name . '.php';
            self::$dados[$name] = $config;
        }
    }

    public static function read($key) {
        return self::findArray($key, self::$dados);
    }

    public static function write($key, $value) {
        return self::$dados[$key] = $value;
    }

}
