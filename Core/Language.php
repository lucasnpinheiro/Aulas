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
class Language extends App {

    public static $dados = array();
    public $idioma = 'pt_BR';

    public function __construct() {
        parent::__construct();
    }

    public function load($name) {
        if (file_exists(ROOT . 'Language' . DS . $this->idioma . DS . $name . '.php')) {
            require_once ROOT . 'Language' . DS . $this->idioma . DS . $name . '.php';
            self::$dados[$name] = $lang;
        }
    }

    public static function read($key) {
        return self::findArray($key, self::$dados);
    }

    public static function write($key, $value) {
        return self::$dados[$key] = $value;
    }

}
