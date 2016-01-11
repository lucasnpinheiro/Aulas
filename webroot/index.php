<?php

ini_set('default_charset', 'UTF-8');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function debug($str) {
    echo '<div style="padding: 25px;">';
    echo '<pre style="color:black;">';
    $a = debug_backtrace();
    echo '<div style="color:red;"><strong>File: </strong>' . $a[0]['file'] . '</div>';
    echo '<div style="color:red;"><strong>Line: </strong>' . $a[0]['line'] . '</div>';
    if (isset($a[1]['class']) and ! empty($a[1]['class'])) {
        echo '<div style="color:red;"><strong>Class: </strong>' . $a[1]['class'] . '</div>';
    }
    if (isset($a[1]['function']) and ! empty($a[1]['function'])) {
        echo '<div style="color:red;"><strong>Function: </strong>' . $a[1]['function'] . '</div>';
    }
    var_dump($str);
    echo '</pre>';
    echo '</hr>';
    echo '</div>';
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

function __autoload($class_name) {
    try {
        $class_name = str_replace('\\', DS, $class_name);
        if (!file_exists(ROOT . $class_name . '.php')) {
            throw new \Exception('Não foi possivel localizar a classe "' . ROOT . $class_name . '.php".', 500);
        } else {
            require_once ROOT . $class_name . '.php';
        }
    } catch (\Exception $exc) {
        debug($exc);
    }
}

$router = new Core\Router();
$router->run();
