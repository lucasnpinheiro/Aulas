<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppShell
 *
 * @author lucas
 */

namespace Shell\Command;

use Core\Inflector;

class AppShell
{

    //put your code here
    public $params = [];

    public function __construct($argv = [])
    {
        $this->params = $argv ? $argv : $_SERVER['argv'];
        $this->params = array_slice($this->params, 1);
    }

    public function init()
    {
    }

    public function out($str, $lines = 1)
    {
        print_r($str);
        for ($i = 0; $i < $lines; $i++) {
            echo "\r\n";
        }
    }

    public function fim($exit = 1)
    {
        $this->out('Fim de script Shell');
        exit($exit);
    }

    public function load()
    {
        $class = '\Shell\Command\\' . Inflector::camelize($this->params[0]) . 'Shell';
        $file = ROOT . trim(str_replace('\\', '/', $class), '/') . '.php';
        $this->color($file);
        if (file_exists($file)) {
            $this->params = array_slice($this->params, 1);
            $class = new $class();
            call_user_func_array([$class, 'init'], $this->params);
        }
        $this->fim(0);
    }

    public function color($str, $cor = 'Blue')
    {
        $color = [
            'Black' => '0;30',
            'Red' => '0;31',
            'Green' => '0;32',
            'Brown' => '0;33',
            'Blue' => '0;34',
            'Purple' => '0;35',
            'Cyan' => '0;36'
        ];
        $cor = Inflector::camelize($cor);
        if (empty($color[$cor])) {
            $cor = 'Black';
        }
        $str = var_export($str, true);
        $this->out("\033[" . $color[$cor] . "m" . $str . "\033[0m");
    }

    /**
     * 
     * Carrega uma tabela para o controller
     * 
     * @param type $name
     * @return \Core\Controller
     */
    public function loadModel($name)
    {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $table = '\App\Model\Table\\' . $table;
        $this->{$name} = new $table();
        return $this;
    }
}
