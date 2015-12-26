<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;


use Core\Configure;

/**
 * Description of Conection
 *
 * @author lucas
 */
class Conection {

    // mantendo a conexão com o dbname de dados
    public static $instance;

    //put your code here
    public function __construct() {
        $c = new Configure();
        $c->load('database');
    }

    public static function db() {
        // verifica se já existe conexão, caso não faz a conexão com o dbname de dados.
        if (!isset(self::$instance)) {
            try {
                self::$instance = new \PDO(
                        Configure::read('database.drive') . ':host=' . Configure::read('database.host') . ';dbname=' . Configure::read('database.banco'), Configure::read('database.usuario'), Configure::read('database.senha'), array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    \PDO::ATTR_PERSISTENT => true
                        )
                );
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $exc) {
                debug($exc);
            }
        }
        // retorna a conexão com o dbname de dados
        return self::$instance;
    }

}
