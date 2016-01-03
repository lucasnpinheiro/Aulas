<?php

namespace Core\Database;

use Core\Database\Conection;
use Core\Configure;
use Core\Cache;
use Core\Validacao\Validacao;

// Classe generica para conexão com o dbname de dados
class Database {

    // itentificação da classe de objetos que vai ser usada
    public $primary_key = 'id';
    public $classe = '';
    public $tabela = '';
    private $_validacao;
    private $_cache;
    public $validacao = [];
    public $data = [];
    public $validacao_error = [];
    public $cache = true;
    private $pdo = null;

    public function __construct() {
        $c = new Configure();
        $c->load('database');
        $this->classe = '\\src\\Model\\Entity\\' . $this->classe;
        $this->pdo = Conection::db();
        $this->_cache = new Cache('model' . DS . $this->tabela);
    }

    // realiza a consulta de um unico objeto referente a classe selecionada
    public function existe($id) {
        $count = $this->pdo->query('SELECT COUNT(*) as total FROM ' . $this->tabela . ' WHERE id = ' . $id)->fetchObject();
        return (bool) $count->total > 0 ? true : false;
    }

    public function existeCampo($campo, $valor) {
        $count = $this->pdo->query('SELECT COUNT(*) as total FROM ' . $this->tabela . ' WHERE ' . $campo . ' = ' . $valor)->fetchObject();
        return (bool) $count->total > 0 ? true : false;
    }

    // realiza a consulta de varios objeto referente a classe selecionada
    public function all() {
        $query = 'SELECT * FROM ' . $this->tabela;
        if ($this->cache) {
            $cache = $this->_cache->read($query);
            if (is_null($cache)) {
                $cache = $this->pdo->query($query)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
                $this->_cache->save($query, $cache);
            }
            return $cache;
        } else {
            return $this->pdo->query($query)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
        }
    }

    // realiza a consulta de varios objeto referente a classe selecionada
    public function __call($name, $arguments) {
        if (substr($name, 0, 6) === 'findBy') {
            $find = $this->_argumentos(substr($name, 6), $arguments);
            $query = 'SELECT * FROM ' . $this->tabela . ' WHERE ' . $find . ' LIMIT 1';
            if ($this->cache) {
                $cache = $this->_cache->read($query);
                if (is_null($cache)) {
                    $cache = $this->pdo->query($query)->fetchObject($this->classe);
                    $this->_cache->save($query, $cache);
                }
                return $cache;
            } else {
                return $this->pdo->query($query)->fetchObject($this->classe);
            }
        } else if (substr($name, 0, 9) === 'findAllBy') {
            $find = $this->_argumentos(substr($name, 9), $arguments);
            $query = 'SELECT * FROM ' . $this->tabela . ' WHERE ' . $find;
            if ($this->cache) {
                $cache = $this->_cache->read($query);
                if (is_null($cache)) {
                    $cache = $this->pdo->query($query)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
                    $this->_cache->save($query, $cache);
                }
                return $cache;
            } else {
                return $this->pdo->query($query)->fetchAll(\PDO::FETCH_CLASS, $this->classe);
            }
        } else if (substr($name, 0, 11) === 'findCountBy') {
            $find = $this->_argumentos(substr($name, 11), $arguments);
            $retorno = $this->pdo->query('SELECT COUNT(*) AS total FROM ' . $this->tabela . ' WHERE ' . $find)->fetchObject();
            return $retorno->total;
        }
    }

    public function delete($id) {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('DELETE FROM ' . $this->tabela . ' WHERE id=' . $id)->execute();
    }

    public function insert($dados = array()) {
        $m = $c = $v = array();
        $this->setData($dados, 'data_cadastro');
        if ($this->validar()) {
            $this->_cache->deleteAll();
            foreach ($this->data as $key => $value) {
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
        $this->setData($dados, 'data_alteracao');
        if ($this->validar()) {
            $this->_cache->deleteAll();
            $m = $c = $v = array();
            foreach ($this->data as $key => $value) {
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

    public function beforeSave() {
        
    }

    public function save($dados = array()) {
        $this->data = $dados;
        $this->beforeSave();
        if (isset($this->data[$this->primary_key]) AND is_int($this->data[$this->primary_key]) AND $this->data[$this->primary_key] > 0) {
            return $this->update($this->data[$this->primary_key], $this->data);
        } else {
            return $this->insert($this->data);
        }
    }

    public function truncate() {
        $this->_cache->deleteAll();
        $find = $this->pdo->query('TRUNCATE ' . $this->tabela)->execute();
        return (bool) $find->total;
    }

    public function drop() {
        $this->_cache->deleteAll();
        $find = $this->pdo->query('DROP ' . $this->tabela)->execute();
        return (bool) $find->total;
    }

    private function setData($dados, $coluna) {
        $exit = $this->colunaExiste($coluna);
        if ($exit) {
            $dados[$coluna] = date('Y-m-d H:i:s');
        }
        $this->data = $dados;
        $class = new $this->classe;
        $class->_setEntity($this->data);
        return $class->_getEntity();
    }

    private function colunaExiste($coluna) {
        debug('SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = "' . Configure::read('database.banco') . '" AND TABLE_NAME = "' . $this->tabela . '" AND COLUMN_NAME = "' . $coluna . '"');
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
            $find .= strtolower(\Core\Inflector::underscore($value)) . '="' . $arguments[$key] . '"';
        }
        return $find;
    }

    private function validar() {
        $this->_validacao = new Validacao($this->data);
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
        if (count($this->_validacao->error()) > 0) {
            $this->validacao_error = $this->_validacao->error();
            return false;
        }

        return TRUE;
    }

    public function _convertData($data, $separador = '/', $include = '-') {
        $data = explode($separador, $data);
        return implode($include, array_reverse($data));
    }

}
