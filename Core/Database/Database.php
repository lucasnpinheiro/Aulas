<?php

namespace Core\Database;

use Core\Database\Conection;
use Core\Configure;
use Core\Cache;
use Core\Validacao\Validacao;
use Core\Database\Schema;
use Core\Database\Dump;

/**
 * Classe que realiza o CRUD com o banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Database {

    use \Core\Traits\FuncoesTrait;

    /**
     *
     * Nome da chave primaria da tabela.
     * 
     * @var string 
     */
    public $primary_key = 'id';

    /**
     *
     * Nome da chave primaria da tabela.
     * 
     * @var string 
     */
    public $display = null;

    /**
     *
     * Nome da classe Entyties que vai ser chamada para o carregamento do objeto de cada registro no banco de dados.
     * 
     * @var string 
     */
    public $classe = '';

    /**
     *
     * Nome da tabela do banco de dados que a classe vai manipular os dados.
     * 
     * @var string 
     */
    public $tabela = '';

    /**
     *
     * Variavel que guarda os dados que serão salvo no banco de dados.
     * 
     * @var array 
     */
    public $data = [];

    /**
     *
     * Variavel que guarda as regras de validação dos dados antes de salvar na tabela.
     * 
     * @var array 
     */
    public $validacao = [];

    /**
     *
     * Variavel que guarda os erros que foram gerados na validação dos dados.
     * 
     * @var array 
     */
    public $validacao_error = [];

    /**
     *
     * Variavel que informa se vai gerar cache dos dados para otimizar o tempo de consulta no banco de dados.
     * 
     * @var bool 
     */
    public $cache = false;

    /**
     *
     * Variavel que informa se vai gerar cache dos dados para otimizar o tempo de consulta no banco de dados.
     * 
     * @var bool 
     */
    public $total_registro = 0;

    /**
     *
     * variavel que contem uma string de campos que serão retornados para uso nos selects.
     * 
     * @var string 
     */
    public $_sql = [];

    /**
     *
     * variavel que contem uma string de campos que serão retornados para uso nos selects.
     * 
     * @var string 
     */
    public $log = true;

    /**
     *
     * variavel que contem a classe de validação instanciada.
     * 
     * @var object 
     */
    protected $_validacao = null;

    /**
     *
     * variavel que contem a classe de cahce instanciada.
     * 
     * @var object 
     */
    protected $_cache = null;

    /**
     *
     * variavel que contem a classe de conexão com o banco de dados instanciada.
     * 
     * @var object 
     */
    protected $pdo = null;

    /**
     *
     * variavel que contem um array de argumentos para uso nos selects.
     * 
     * @var array 
     */
    protected $_where = [];

    /**
     *
     * variavel que contem um array de ordenação para uso nos selects.
     * 
     * @var array 
     */
    protected $_order = [];

    /**
     *
     * variavel que contem um array de agrupamento para uso nos selects.
     * 
     * @var array 
     */
    protected $_group = [];

    /**
     *
     * variavel que contem uma string de limit para uso nos selects.
     * 
     * @var string 
     */
    protected $_limit = null;

    /**
     *
     * variavel que contem uma string de campos que serão retornados para uso nos selects.
     * 
     * @var string 
     */
    protected $_from = '*';
    private $_params = null;
    private $_contain = [];

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        $c = new Configure();
        $c->load('database');
        $this->log = (bool) Configure::read('database.log');
        $class = explode('\\', get_class($this));
        $class = end($class);
        $this->classe = substr($class, 0, -5) . 'Entity';
        $this->classe = '\\App\\Model\\Entity\\' . $this->classe;
        $this->pdo = Conection::db();
        $this->_cache = new Cache('model' . DS . $this->tabela);
    }

    public function __get($name) {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * 
     * Traz informações da estrutura do banco de dados
     * 
     * @return Schema
     */
    public function schema() {
        return new Schema($this->tabela, $this->pdo);
    }

    /**
     * 
     * Traz rotinas para fazer backup e restaurar o banco de dados
     * 
     * @return Dump
     */
    public function dump() {
        return new Dump($this->tabela, $this->pdo);
    }

    /**
     * 
     * função que verifica se um registro exite.
     * 
     * @param int $id
     * @return boolean
     */
    public function existe($id) {
        return (bool) $this->existeCampo($this->primary_key, $id);
    }

    /**
     * 
     * função que verifica se um registro exite ou grupo de registro existe.
     * 
     * @param string $campo
     * @param string $valor
     * @return boolean
     */
    public function existeCampo($campo, $valor) {
        $sql = 'SELECT COUNT(*) as total FROM ' . $this->tabela . ' WHERE ' . $campo . ' = "' . $valor . '"';
        $this->_sql[] = $sql;
        $count = $this->pdo->query($sql)->fetchObject();
        return (bool) $count->total > 0 ? true : false;
    }

    /**
     * 
     * função que faz uma consulta pernsonalizada no banco de dados.
     * 
     * @param string $query
     * @return array retorna um array de objetos
     */
    public function query($query) {
        $this->_sql[] = $query;
        try {
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
        } catch (\PDOException $exc) {
            new \Core\MyException($exc);
        } catch (\Exception $exc) {
            new \Core\MyException($exc);
        }
    }

    /**
     * 
     * função que faz uma consulta no banco de dados.
     * 
     * @return array retorna um array de objetos
     */
    public function all() {
        try {
            $params = $this->_getWhere();
            $this->_params = $params;
            $query = 'SELECT ' . $params['from'] . ' FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ($params['limit'] != '' ? ' LIMIT ' . $params['limit'] : '');
            $this->_sql[] = $query;
            if ($this->cache) {
                $cache = $this->_cache->read($query);
                if (is_null($cache)) {
                    $cache = $this->pdo->query($query)->fetchAll(\PDO::FETCH_OBJ);
                    $this->_cache->save($query, $cache);
                }
                $return = $cache;
            } else {
                $return = $this->pdo->query($query)->fetchAll(\PDO::FETCH_OBJ);
            }
            $retorno = [];
            if (!empty($return)) {
                foreach ($return as $key => $value) {
                    $retorno[$key] = new $this->classe();
                    foreach ($value as $k => $v) {
                        $retorno[$key]->{$k} = $v;
                    }
                    $retorno[$key]->popula();
                    $retorno[$key]->contain($this->_contain);
                    $retorno[$key]->relacoes();
                }
            }
            return $retorno;
        } catch (\PDOException $exc) {
            new \Core\MyException($exc);
        } catch (\Exception $exc) {
            new \Core\MyException($exc);
        }
    }

    /**
     * 
     * função que faz uma consulta no banco de dados.
     * 
     * @return array retorna um array de objetos
     */
    public function combo() {
        try {
            if (empty($this->display)) {
                $this->display = $this->primary_key;
            }
            $this->from([$this->primary_key, $this->display]);
            $params = $this->_getWhere();
            $query = 'SELECT ' . $params['from'] . ' FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ($params['limit'] != '' ? ' LIMIT ' . $params['limit'] : '');
            $this->_sql[] = $query;
            if ($this->cache) {
                $cache = $this->_cache->read($query);
                if (is_null($cache)) {
                    $cache = $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
                    $this->_cache->save($query, $cache);
                }
                $return = $cache;
            } else {
                $return = $this->pdo->query($query)->fetchAll(\PDO::FETCH_ASSOC);
            }
            if (!empty($return)) {
                $r = $return;
                $return = [];
                foreach ($r as $key => $value) {
                    $return[$value[$this->primary_key]] = $value[$this->display];
                }
            }
            return $return;
        } catch (\PDOException $exc) {
            new \Core\MyException($exc);
        } catch (\Exception $exc) {
            new \Core\MyException($exc);
        }
    }

    /**
     * 
     * função que faz uma consulta no banco de dados.
     * 
     * @return array retorna um array de objetos
     */
    public function allCount() {
        try {
            $params = $this->_params;
            if ($params['group'] != '') {
                $query = 'SELECT COUNT(Contagem.total) AS total FROM (SELECT COUNT(*) AS total FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ') AS Contagem';
            } else {
                $query = 'SELECT COUNT(*) AS total FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '');
            }
            $this->_sql[] = $query;
            $return = $this->pdo->query($query)->fetchObject();
            $this->total_registro = $return->total;
            return $return;
        } catch (\PDOException $exc) {
            new \Core\MyException($exc);
        } catch (\Exception $exc) {
            new \Core\MyException($exc);
        }
    }

    /**
     * 
     * função que faz uma consulta no banco de dados.
     * 
     * @return object retorna um objeto da classe
     */
    public function find() {
        try {
            $this->limit(1);
            /* $params = $this->_getWhere();
              $this->_params = $params;
              $query = 'SELECT ' . $params['from'] . ' FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ($params['limit'] != '' ? ' LIMIT ' . $params['limit'] : '');
              $this->_sql[] = $query;
              if ($this->cache) {
              $cache = $this->_cache->read($query);
              if (is_null($cache)) {
              $cache = $this->pdo->query($query)->fetchObject($this->classe);
              $this->_cache->save($query, $cache);
              }
              $return = $cache;
              } else {
              $return = $this->pdo->query($query)->fetchObject($this->classe);
              } */
            $return = $this->all();
            if (!empty($return)) {
                $this->total_registro = 1;
                return $return[0];
            }
            return false;
        } catch (\PDOException $exc) {
            new \Core\MyException($exc);
        } catch (\Exception $exc) {
            new \Core\MyException($exc);
        }
    }

    /**
     * 
     * função automatica para consulta no banco de dados.
     * 
     * @param string $name
     * @param array $arguments
     * @return array|object
     */
    public function __call($name, $arguments) {
        if (substr($name, 0, 6) === 'findBy') {
            $find = $this->_argumentos(substr($name, 6), $arguments);
            return $this->find();
        } elseif (substr($name, 0, 9) === 'findAllBy') {
            $find = $this->_argumentos(substr($name, 9), $arguments);
            return $this->all();
        } elseif (substr($name, 0, 10) === 'findLikeBy') {
            $find = $this->_argumentos(substr($name, 10), $arguments, 'like');
            return $this->all();
        } elseif (substr($name, 0, 11) === 'findCountBy') {
            $find = $this->_argumentos(substr($name, 11), $arguments);
            $params = $this->_getWhere();
            $query = 'SELECT COUNT(*) AS total FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '');
            $this->_sql[] = $query;
            $retorno = $this->pdo->query($query)->fetchObject();
            return $retorno->total;
        }
    }

    /**
     * 
     * função que remove um registro no banco de dados.
     * 
     * @param int $id
     * @return boolean
     */
    public function delete($id) {
        $this->_cache->deleteAll();
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE id=' . $id;
        $this->_sql[] = $query;
        return (bool) $this->pdo->query($query)->execute();
    }

    /**
     * 
     * função que remove um registro no banco de dados.
     * 
     * @param int $id
     * @return boolean
     */
    public function deleteAll($argumentos = []) {
        $this->_cache->deleteAll();
        $a = [];
        foreach ($argumentos as $key => $value) {
            $a[] = $key . '="' . $value . '"';
        }
        $query = 'DELETE FROM ' . $this->tabela . ' ' . (count($a) ? ' WHERE ' . implode(' AND ', $a) : '');
        $this->_sql[] = $query;
        return (bool) $this->pdo->query($query)->execute();
    }

    /**
     * 
     * função que faz as insersão de dados no banco de dados.
     * 
     * @param array $dados
     * @return int|bool
     */
    private function insert($dados = []) {
        $m = $c = $v = [];
        $dados = $this->setData($dados, 'created');
        if ($this->validar()) {

            foreach ($dados as $key => $value) {
                $c[] = $key;
                $m[] = ':' . $key;
                $v[] = $value;
            }
            $db = $this->pdo;
            $query = 'INSERT INTO ' . $this->tabela . ' (' . implode(', ', $c) . ') VALUES (' . implode(', ', $m) . ') ';
            $this->_sql[] = $query;
            $insert = $db->prepare($query);

            foreach ($m as $key => $value) {
                $insert->bindParam($value, $v[$key]);
            }
            $insert->execute();
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * 
     * função que faz as alteração de dados no banco de dados.
     * 
     * @param int $id
     * @param array $dados
     * @return boolean
     */
    private function update($id, $dados = []) {
        $dados = $this->setData($dados, 'modified');
        if ($this->validar()) {

            $m = $c = $v = [];
            foreach ($dados as $key => $value) {
                $c[] = $key . '=:' . $key;
                $m[] = ':' . $key;
                $v[] = $value;
            }
            $db = $this->pdo;
            $query = 'UPDATE ' . $this->tabela . ' SET ' . implode(', ', $c) . ' WHERE id=' . $id;
            $this->_sql[] = $query;
            $update = $db->prepare($query);
            foreach ($m as $key => $value) {
                $update->bindParam($value, $v[$key]);
            }
            return (bool) $update->execute();
        }
        return false;
    }

    /**
     * 
     * função que remove um registro no banco de dados.
     * 
     * @param int $id
     * @return boolean
     */
    public function updateAll($argumentos = [], $find = []) {
        $this->_cache->deleteAll();
        $a = [];
        foreach ($argumentos as $key => $value) {
            $a[] = $key . '="' . $value . '"';
        }
        $f = [];
        foreach ($find as $key => $value) {
            $f[] = $key . '="' . $value . '"';
        }
        $query = 'UPDATE ' . $this->tabela . ' SET ' . (count($a) ? implode(', ', $a) : '') . ' ' . (count($f) ? ' WHERE ' . implode(' AND ', $f) : '');
        $this->_sql[] = $query;
        return (bool) $this->pdo->query($query)->execute();
    }

    /**
     * função callback, usada para tratar os dados antes de salvar no banco de dados.
     */
    public function beforeSave() {
        
    }

    /**
     * função callback, usada para tratar os dados antes de salvar no banco de dados.
     */
    public function afterSave(array $data = [], $create = true) {
        
    }

    /**
     * 
     * função que salva os dados no banco de dados.
     * 
     * @param array $dados
     * @return int|bool
     */
    public function save($dados = []) {
        $this->_cache->deleteAll();
        $create = true;
        $dados = json_decode(json_encode($dados), true);
        $this->data = $dados;
        $this->beforeSave();
        if (isset($this->data[$this->primary_key]) and $this->data[$this->primary_key] > 0) {
            $retorno = $this->update($this->data[$this->primary_key], $this->data);
            $create = false;
        } else {
            $retorno = $this->data[$this->primary_key] = $this->insert($this->data);
        }

        $this->afterSave($this->data, $create);

        if ($retorno) {
            return $this;
        }
        return false;
    }

    /**
     * 
     * função que faz o tratamento dos dados para consulta no banco de dados.
     * 
     * @param string $key
     * @param string|int|array $value
     * @param string $type
     * @param string $condition
     * @return \Core\Database\Database
     */
    public function where($key, $value, $type = '=', $condition = 'AND') {
        $type = strtoupper($type);
        switch ($type) {
            case '=':
                $value = $this->quote($value);
                if (is_array($value)) {
                    $this->_where[][$condition] = $key . ' IN("' . implode('", "', $value) . '")';
                } else {
                    $this->_where[][$condition] = $key . ' = "' . $value . '"';
                }
                break;

            case '!=':
            case '<>':
                $value = $this->quote($value);
                if (is_array($value)) {
                    $this->_where[][$condition] = $key . ' NOT IN("' . implode('", "', $value) . '")';
                } else {
                    $this->_where[][$condition] = $key . ' != "' . $value . '"';
                }
                break;

            case 'LIKE':
                $value = $this->quote($value, '%', '%');
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $this->_where[][$condition] = $key . ' LIKE "' . $v . '"';
                    }
                } else {
                    $this->_where[][$condition] = $key . ' LIKE "' . $value . '"';
                }
                break;

            default:
                $value = $this->quote($value);
                $this->_where[][$condition] = $key . ' ' . $type . ' "' . $value . '"';
                break;
        }
        return $this;
    }

    /**
     * 
     * função que faz o tratamento dos dados para consulta no banco de dados.
     * 
     * @param string $key
     * @param string|int|array $value
     * @param string $type
     * @return \Core\Database\Database
     */
    public function orWhere($key, $value, $type = '=') {
        $this->where($key, $value, $type, 'OR');
        return $this;
    }

    /**
     * 
     * função que faz a junção dos tipos de ordenação do resultado no banco de dados.
     * 
     * @param string $key
     * @param string $order
     * @return \Core\Database\Database
     */
    public function order($key, $order = 'ASC') {
        $this->_order[] = $key . ' ' . strtoupper($order);
        return $this;
    }

    /**
     * 
     * função que faz a junção dos tipos de agrupamento de dados do resultado no banco de dados.
     * 
     * @param string $key
     * @return \Core\Database\Database
     */
    public function group($key) {
        $this->_group[] = $key;
        return $this;
    }

    /**
     * 
     * função que faz o limit de registro no banco de dados.
     * 
     * @param int $inicio
     * @param int $fim
     * @return \Core\Database\Database
     */
    public function limit($inicio = 1, $fim = null) {
        $this->_limit = trim($inicio . ' ' . (!is_null($fim) ? ', ' . $fim : ''));
        return $this;
    }

    /**
     * 
     * função que faz a junção dos dados para campos de pesquisa.
     * 
     * @param string|array $from
     * @return \Core\Database\Database
     */
    public function from($from = '*') {
        $this->_from = trim((is_array($from) ? implode(', ', $from) : $from), ',');
        return $this;
    }

    /**
     * 
     * função que faz um pre tratamento no banco de dados.
     * 
     * @param array $dados
     * @param string $coluna
     * @return array
     */
    private function setData($dados, $coluna) {
        $newDados = [];
        $coluns = $this->schema()->columns();
        if (count($coluns) > 0) {
            foreach ($coluns as $key => $value) {
                if (isset($dados[$key])) {
                    $newDados[$key] = $dados[$key];
                }
                if ($key === $coluna) {
                    $newDados[$key] = date('Y-m-d H:i:s');
                }
            }
        }
        $dados = array_merge($dados, $newDados);
        $this->data = $dados;
        return $newDados;
    }

    /**
     * 
     * função que faz um pre tratamento nas condições de consulta na tabela do banco de dados.
     * 
     * @param string $campos
     * @param array $arguments
     * @return string
     */
    private function _argumentos($campos, $arguments, $tipo = '=') {
        $type = 'AND';
        if (stripos($campos, 'And') !== false) {
            $campos = explode('And', $campos);
        } elseif (stripos($campos, 'Or') !== false) {
            $campos = explode('Or', $campos);
            $type = 'OR';
        } else {
            $campos = [$campos];
        }
        foreach ($campos as $key => $value) {
            $this->where(strtolower(\Core\Inflector::underscore($value)), $arguments[$key], $tipo, $type);
        }
    }

    /**
     * 
     * função que faz a validação dos dados antes de salvar no banco de dados.
     * 
     * @return boolean
     */
    private function validar() {
        $this->_validacao = new Validacao($this->data, $this);
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

        return true;
    }

    /**
     * 
     * função que faz a tratamento de todos os dados para gerar parte do sql para consulta no banco de dados.
     * 
     * @return array
     */
    private function _getWhere() {
        $where = [];
        if (count($this->_where) > 0) {
            foreach ($this->_where as $key => $value) {
                foreach ($value as $k => $v) {
                    $where[] = $k . ' ' . $v;
                }
            }
        }
        $return = [
            'where' => '',
            'order' => '',
            'group' => '',
            'limit' => '',
        ];
        $return['where'] = trim(trim(trim(implode(' ', $where), 'AND'), 'OR'));
        if (count($this->_order) > 0) {
            $return['order'] = implode(', ', $this->_order);
        }
        if (count($this->_group) > 0) {
            $return['group'] = implode(', ', $this->_group);
        }
        $return['limit'] = $this->_limit;
        $return['from'] = $this->_from;
        $this->_where = [];
        $this->_order = [];
        $this->_group = [];
        $this->_limit = null;
        $this->_from = '*';
        return $return;
    }

    /**
     * 
     * @param type $value
     * @param type $before
     * @param type $after
     * @return type
     */
    private function quote($value, $before = '', $after = '') {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $before . $this->__defineTypes(trim($value)) . $after;
            }
            return $value;
        }
        return $before . $this->__defineTypes(trim($value)) . $after;
    }

    private function __defineTypes($value) {
        $value = (trim($value) == '' ? null : $value);
        switch (gettype($value)) {
            case 'int':
            case 'integer':
                return (int) $value;

                break;

            case 'float':
            case 'double':
                return (float) $value;

                break;

            case 'NULL':
                return null;

                break;

            case 'boolean':
                return (int) $value;

                break;

            case 'array':
            case 'object':
            case 'resource':
                return $value;

                break;

            default:
                return (string) $value;
                break;
        }
    }

    public function __destruct() {
        if ($this->log === true) {
            if (!empty($this->_sql)) {
                \Core\Log::write($this->_sql, 'SQL');
            }
        }
    }

    public function contain($class) {
        if (is_array($class)) {
            foreach ($class as $key => $value) {
                $this->_contain[$value] = $value;
            }
        } else {
            $this->_contain[$class] = $class;
        }
        return $this;
    }

}
