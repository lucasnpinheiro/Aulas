<?php

namespace Core\Database;

use Core\Database\Conection;
use Core\Configure;
use Core\Validacao\Validacao;

// Classe generica para conexão com o dbname de dados
class Database {

    // itentificação da classe de objetos que vai ser usada
    public $primary_key = 'id';
    public $classe = '';
    public $tabela = '';
    private $_validacao;
    public $validacao = [];
    public $validacao_error = [];
    private $pdo = null;

    public function __construct() {
        $c = new Configure();
        $c->load('database');
        $this->classe = '\\src\\Model\\Entity\\' . $this->classe;
        $this->pdo = Conection::db();
    }

    // realiza a consulta de um unico objeto referente a classe selecionada
    public function existe($id) {
        $count = $this->pdo->query('SELECT COUNT(*) as total FROM ' . $this->tabela . ' WHERE id = ' . $id)->fetchObject();
        return (bool) $count->total > 0 ? true : false;
    }

    // realiza a consulta de varios objeto referente a classe selecionada
    public function all() {
        return $this->pdo->query('SELECT * FROM ' . $this->tabela)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
    }

    // realiza a consulta de varios objeto referente a classe selecionada
    public function __call($name, $arguments) {
        if (substr($name, 0, 6) === 'findBy') {
            $find = $this->_argumentos(substr($name, 6), $arguments);
            return $this->pdo->query('SELECT * FROM ' . $this->tabela . ' WHERE ' . $find)->fetchObject($this->classe);
        } else if (substr($name, 0, 9) === 'findAllBy') {
            $find = $this->_argumentos(substr($name, 9), $arguments);
            return $this->pdo->query('SELECT * FROM ' . $this->tabela . ' WHERE ' . $find)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
        } else if (substr($name, 0, 11) === 'findCountBy') {
            $find = $this->_argumentos(substr($name, 11), $arguments);
            $retorno = $this->pdo->query('SELECT COUNT(*) AS total FROM ' . $this->tabela . ' WHERE ' . $find)->fetchObject();
            return $retorno->total;
        }
    }

    public function delete($id) {
        return (bool) $this->pdo->query('DELETE FROM ' . $this->tabela . ' WHERE id=' . $id)->execute();
    }

    public function insert($dados = array()) {
        $m = $c = $v = array();
        $dados = $this->setData($dados, $this->tabela, 'data_cadastro');
        if ($this->validar($dados)) {
            foreach ($dados as $key => $value) {
                $c[] = $key;
                $m[] = ':' . $key;
                $v[] = $value;
            }
            $db = $this->pdo;
            $insert = $db->prepare('INSERT INTO ' . $this->tabela . ' (' . implode(', ', $c) . ') VALUES (' . implode(', ', $m) . ') ');

            foreach ($m as $key => $value) {
                $insert->bindParam($value, $v[$key]);
            }
            $insert->execute();
            return $db->lastInsertId();
        }
        return false;
    }

    public function update($id, $dados = array()) {
        $dados = $this->setData($dados, $this->tabela, 'data_alteracao');
        if ($this->validar($dados)) {
            $m = $c = $v = array();
            foreach ($dados as $key => $value) {
                $c[] = $key . '=:' . $key;
                $m[] = ':' . $key;
                $v[] = $value;
            }
            $db = $this->pdo;
            $insert = $db->prepare('UPDATE ' . $this->tabela . ' SET ' . implode(', ', $c) . ' WHERE id=' . $id);
            foreach ($m as $key => $value) {
                $insert->bindParam($value, $v[$key]);
            }
            return (bool) $insert->execute();
        }
        return false;
    }

    public function beforeSave($dados = array()) {
        return $dados;
    }

    public function save($dados = array()) {
        $dados = $this->beforeSave($dados);
        if (isset($dados[$this->primary_key]) AND is_int($dados[$this->primary_key]) AND $dados[$this->primary_key] > 0) {
            return $this->update($dados[$this->primary_key], $dados);
        } else {
            return $this->insert($dados);
        }
    }

    public function truncate() {
        $find = $this->pdo->query('TRUNCATE ' . $this->tabela)->execute();
        return (bool) $find->total;
    }

    public function drop() {
        $find = $this->pdo->query('DROP ' . $this->tabela)->execute();
        return (bool) $find->total;
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
        $find = $this->pdo->query('SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = "' . Configure::read('database.banco') . '" AND TABLE_NAME = "' . $this->tabela . '" AND COLUMN_NAME = "' . $coluna . '"')->fetch(\PDO::FETCH_OBJ);
        return (bool) $find->total;
    }

    private function _argumentos($campos, $arguments) {
        $type = 'AND';
        if (stripos($campos, 'And') !== FALSE) {
            $campos = explode('And', $campos);
        } else if (stripos($campos, 'Or') !== FALSE) {
            $campos = explode('Or', $campos);
            $type = 'OR';
        } else {
            $campos = array($campos);
        }
        $find = '';
        foreach ($campos as $key => $value) {
            if ($find != '') {
                $find .= ' ' . $type . ' ';
            }
            $find .= strtolower($value) . '="' . $arguments[$key] . '"';
        }
        return $find;
    }

    private function validar($dados) {
        $this->_validacao = new Validacao($dados);
        foreach ($this->validacao as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $this->_validacao->add($key, $k, $v);
                }
            } else {
                $this->_validacao->add($key, $value);
            }
        }
        $this->_validacao->run();
        if (empty($this->_validacao->error())) {
            return TRUE;
        }
        $this->validacao_error = $this->_validacao->error();
        return false;
    }

}
