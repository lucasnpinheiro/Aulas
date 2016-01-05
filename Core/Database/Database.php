<?php

namespace Core\Database;

use Core\Database\Conection;
use Core\Configure;
use Core\Cache;
use Core\Validacao\Validacao;

/**
 * Classe que realiza o CRUD com o banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Database {

    /**
     *
     * Nome da chave primaria da tabela.
     * 
     * @var string 
     */
    public $primary_key = 'id';

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
    public $cache = true;

    /**
     *
     * variavel que contem a classe de validação instanciada.
     * 
     * @var object 
     */
    private $_validacao = null;

    /**
     *
     * variavel que contem a classe de cahce instanciada.
     * 
     * @var object 
     */
    private $_cache = null;

    /**
     *
     * variavel que contem a classe de conexão com o banco de dados instanciada.
     * 
     * @var object 
     */
    private $pdo = null;

    /**
     *
     * variavel que contem um array de argumentos para uso nos selects.
     * 
     * @var array 
     */
    private $_where = [];

    /**
     *
     * variavel que contem um array de ordenação para uso nos selects.
     * 
     * @var array 
     */
    private $_order = [];

    /**
     *
     * variavel que contem um array de agrupamento para uso nos selects.
     * 
     * @var array 
     */
    private $_group = [];

    /**
     *
     * variavel que contem uma string de limit para uso nos selects.
     * 
     * @var string 
     */
    private $_limit = null;

    /**
     *
     * variavel que contem uma string de campos que serão retornados para uso nos selects.
     * 
     * @var string 
     */
    private $_from = '*';

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        $c = new Configure();
        $c->load('database');
        $this->classe = '\\src\\Model\\Entity\\' . $this->classe;
        $this->pdo = Conection::db();
        $this->_cache = new Cache('model' . DS . $this->tabela);
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
        $count = $this->pdo->query('SELECT COUNT(*) as total FROM ' . $this->tabela . ' WHERE ' . $campo . ' = ' . $valor)->fetchObject();
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
            echo debug($exc);
        } catch (\Exception $exc) {
            echo debug($exc);
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
            $query = 'SELECT ' . $params['from'] . ' FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ($params['limit'] != '' ? ' LIMIT ' . $params['limit'] : '');
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
            echo debug($exc);
        } catch (\Exception $exc) {
            echo debug($exc);
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
            $params = $this->_getWhere();
            $query = 'SELECT ' . $params['from'] . ' FROM ' . $this->tabela . ($params['where'] != '' ? ' WHERE ' . $params['where'] : '') . ($params['group'] != '' ? ' GROUP BY ' . $params['group'] : '') . ($params['order'] != '' ? ' ORDER BY ' . $params['order'] : '') . ($params['limit'] != '' ? ' LIMIT ' . $params['limit'] : '');
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
        } catch (\PDOException $exc) {
            echo debug($exc);
        } catch (\Exception $exc) {
            echo debug($exc);
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

    /**
     * 
     * função que remove um registro no banco de dados.
     * 
     * @param int $id
     * @return boolean
     */
    public function delete($id) {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('DELETE FROM ' . $this->tabela . ' WHERE id=' . $id)->execute();
    }

    /**
     * 
     * função que faz as insersão de dados no banco de dados.
     * 
     * @param array $dados
     * @return int|bool
     */
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

    /**
     * 
     * função que faz as alteração de dados no banco de dados.
     * 
     * @param int $id
     * @param array $dados
     * @return boolean
     */
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

    /**
     * função callback, usada para tratar os dados antes de salvar no banco de dados.
     */
    public function beforeSave() {
        
    }

    /**
     * 
     * função que salva os dados no banco de dados.
     * 
     * @param array $dados
     * @return int|bool
     */
    public function save($dados = array()) {
        $this->data = $dados;
        $this->beforeSave();
        if (isset($this->data[$this->primary_key]) AND is_int($this->data[$this->primary_key]) AND $this->data[$this->primary_key] > 0) {
            return $this->update($this->data[$this->primary_key], $this->data);
        } else {
            return $this->insert($this->data);
        }
    }

    /**
     * 
     * função que limpa a tabela do banco de dados
     * 
     * @return boolean
     */
    public function truncate() {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('TRUNCATE ' . $this->tabela)->execute();
    }

    /**
     * 
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function drop() {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('DROP ' . $this->tabela)->execute();
    }

    /**
     * 
     * função que converte a data passada
     * 
     * @param string $data
     * @param string $separador
     * @param string $include
     * @return string
     */
    public function _convertData($data, $separador = '/', $include = '-') {
        return implode($include, array_reverse(explode($separador, $data)));
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
    public function where($key, $value, $type = '=') {
        $type = strtoupper($type);
        switch ($type) {
            case '=':
                $value = $this->pdo->quote($value);
                if (is_array($value)) {
                    $this->_where[]['AND'] = $key . ' IN(' . $value . ')';
                } else {
                    $this->_where[]['AND'] = $key . ' = ' . $value;
                }
                break;

            case '!=':
            case '<>':
                $value = $this->quote($value);
                if (is_array($value)) {
                    $this->_where[]['AND'] = $key . ' NOT IN(' . $value . ')';
                } else {
                    $this->_where[]['AND'] = $key . ' != ' . $value;
                }
                break;

            case 'LIKE':
                $value = $this->quote($value, '%', '%');
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $this->_where[]['AND'] = $key . ' LIKE "' . $v . '"';
                    }
                } else {
                    $this->_where[]['AND'] = $key . ' LIKE "' . $value . '"';
                }
                break;

            default:
                $value = $this->quote($value);
                $this->_where[]['AND'] = $key . ' ' . $type . ' ' . $value;
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
        $type = strtoupper($type);
        switch ($type) {
            case '=':
                $value = $this->pdo->quote($value);
                if (is_array($value)) {
                    $this->_where[]['OR'] = $key . ' IN(' . $value . ')';
                } else {
                    $this->_where[]['OR'] = $key . ' = ' . $value;
                }
                break;

            case '!=':
            case '<>':
                $value = $this->quote($value);
                if (is_array($value)) {
                    $this->_where[]['OR'] = $key . ' NOT IN(' . $value . ')';
                } else {
                    $this->_where[]['OR'] = $key . ' != ' . $value;
                }
                break;

            case 'LIKE':
                $value = $this->quote($value, '%', '%');
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $this->_where[]['OR'] = $key . ' LIKE "' . $v . '"';
                    }
                } else {
                    $this->_where[]['OR'] = $key . ' LIKE "' . $value . '"';
                }
                break;

            default:
                $value = $this->quote($value);
                $this->_where[]['OR'] = $key . ' ' . $type . ' ' . $value;
                break;
        }
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
        $exit = $this->colunaExiste($coluna);
        if ($exit) {
            $dados[$coluna] = date('Y-m-d H:i:s');
        }
        $this->data = $dados;
        $class = new $this->classe;
        $class->_setEntity($this->data);
        return $class->_getEntity();
    }

    /**
     * 
     * função que verifica se exite uma determinda coluna no banco de dados.
     * 
     * @param string $coluna
     * @return boolean
     */
    private function colunaExiste($coluna) {
        $find = $this->pdo->query('SELECT COUNT(*) AS total FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = "' . Configure::read('database.banco') . '" AND TABLE_NAME = "' . $this->tabela . '" AND COLUMN_NAME = "' . $coluna . '"')->fetch(\PDO::FETCH_OBJ);
        return (bool) $find->total;
    }

    /**
     * 
     * função que faz um pre tratamento nas condições de consulta na tabela do banco de dados.
     * 
     * @param string $campos
     * @param array $arguments
     * @return string
     */
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

        return TRUE;
    }

    /**
     * 
     * função que faz a tratamento de todos os dados para gerar parte do sql para consulta no banco de dados.
     * 
     * @return array
     */
    private function _getWhere() {
        $where = array();
        if (count($this->_where) > 0) {
            foreach ($this->_where as $key => $value) {
                foreach ($value as $k => $v) {
                    $where[] = $k . ' ' . $v;
                }
            }
        }
        $return = array(
            'where' => '',
            'order' => '',
            'group' => '',
            'limit' => '',
        );
        $return['where'] = trim(trim(trim(implode(' ', $where), 'AND'), 'OR'));
        if (count($this->_order) > 0) {
            $return['order'] = implode(', ', $this->_order);
        }
        if (count($this->_group) > 0) {
            $return['group'] = implode(', ', $this->_group);
        }
        $return['limit'] = $this->_limit;
        $return['from'] = $this->_from;
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
                $value[$k] = $this->pdo->quote($before . trim($v) . $after);
            }
            return $value;
        }
        return $this->pdo->quote($before . trim($value) . $after);
    }

}
