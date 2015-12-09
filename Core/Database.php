<?php

namespace Core;

// Classe generica para conexão com o dbname de dados
class Database {

    // itentificação da classe de objetos que vai ser usada
    public $classe = '';
    public $tabela = '';
    // mantendo a conexão com o dbname de dados
    public static $instance;

    public function __construct() {
        $c = new Configure();
        $c->load('database');
        $this->classe = '\\src\\Model\\Entity\\' . $this->classe;
    }

    // cria a consulta com o dbname de dados
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

    // realiza a consulta de um unico objeto referente a classe selecionada
    public function find($id) {
        return Database::db()->query('SELECT * FROM ' . $this->tabela . ' WHERE id = ' . $id)->fetchObject($this->classe);
    }

    // realiza a consulta de varios objeto referente a classe selecionada
    public function all() {
        return Database::db()->query('SELECT * FROM ' . $this->tabela)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
    }

    public function delete($id) {
        return (bool) Database::db()->query('DELETE FROM ' . $this->tabela . ' WHERE id=' . $id)->execute();
    }

    public function insert($dados = array()) {
        $m = $c = $v = array();
        $dados = $this->setData($dados, $this->tabela, 'data_cadastro');
        foreach ($dados as $key => $value) {
            $c[] = $key;
            $m[] = ':' . $key;
            $v[] = $value;
        }
        $db = Database::db();
        $insert = $db->prepare('INSERT INTO ' . $this->tabela . ' (' . implode(', ', $c) . ') VALUES (' . implode(', ', $m) . ') ');

        foreach ($m as $key => $value) {
            $insert->bindParam($value, $v[$key]);
        }
        $insert->execute();
        return $db->lastInsertId();
    }

    public function update($id, $dados = array()) {
        $dados = $this->setData($dados, $this->tabela, 'data_alteracao');
        $m = $c = $v = array();
        foreach ($dados as $key => $value) {
            $c[] = $key . '=:' . $key;
            $m[] = ':' . $key;
            $v[] = $value;
        }
        $db = Database::db();
        $insert = $db->prepare('UPDATE ' . $this->tabela . ' SET ' . implode(', ', $c) . ' WHERE id=' . $id);
        foreach ($m as $key => $value) {
            $insert->bindParam($value, $v[$key]);
        }
        return (bool) $insert->execute();
    }

    private function setData($dados, $coluna) {
        $exit = $this->colunaExiste($this->tabela, $coluna);
        if ($exit) {
            $dados[$coluna] = date('Y-m-d H:i:s');
        }
        $class = new $this->classe;
        $class->_setEntity($dados);
        return $class->_getEntity();
    }

    private function colunaExiste($coluna) {
        $find = Database::db()->query('SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = "' . Configure::read('database.banco') . '" AND TABLE_NAME = "' . $this->tabela . '" AND COLUMN_NAME = "' . $coluna . '"')->fetch(\PDO::FETCH_OBJ);
        return (bool) $find->total;
    }

    public function truncate() {
        $find = Database::db()->query('TRUNCATE ' . $this->tabela)->execute();
        return (bool) $find->total;
    }

    public function drop() {
        $find = Database::db()->query('TRUNCATE ' . $this->tabela)->execute();
        return (bool) $find->total;
    }

}
