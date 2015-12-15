<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function debug($str) {
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    echo '</hr>';
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__) . DS);
}

if (!defined('CORE')) {
    define('CORE', ROOT . 'Core' . DS);
}

if (!defined('APP')) {
    define('APP', ROOT . 'src' . DS);
}

if (!defined('WEBROOT')) {
    define('WEBROOT', 'webroot' . DS);
}
$benchmark = new Core\Benchmark();
$benchmark->Step('Start');

function __autoload($class_name) {
    try {
        $class_name = str_replace('\\', DS, $class_name);
        if (!file_exists(ROOT . $class_name . '.php')) {
            throw new \Exception('Não foi possivel localizar a classe "' . ROOT . $class_name . '.php".', 500);
        } else {
            require_once ROOT . $class_name . '.php';
        }
    } catch (Exception $exc) {
        debug($exc);
    }
}

$router = new Core\Router();
$router->run();
$benchmark->Step('End');
//debug($benchmark->Report('Start', 'End'));
