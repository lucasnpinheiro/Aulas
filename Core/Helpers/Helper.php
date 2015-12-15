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
        $class['nome'] = $this->toUpper($class['nome']);
        $class['class'] = $this->toUpper(str_replace('Helper', '', $class['class'])) . 'Helper';
        self::$_helpers[$class['nome']] = $class;
    }

    public function load() {
        return self::$_helpers;
    }

}
