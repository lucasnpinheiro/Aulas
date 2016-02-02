<?php

ini_set('default_charset', 'UTF-8');

function debug($str) {
    echo var_export($str, true);
    echo "\r\n";
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
require_once '../vendor/autoload.php';
$shell = new \Shell\Command\AppShell();
$shell->load();
