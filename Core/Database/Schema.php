<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;

use Core\Database\Database;

/**
 * Description of Schema
 *
 * @author lucas
 */
class Schema extends Database {

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        parent::__construct();
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
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function optimize() {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('OPTIMIZE TABLE ' . $this->tabela)->execute();
    }

    /**
     * 
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function analyze() {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('ANALYZE TABLE ' . $this->tabela)->execute();
    }

    /**
     * 
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function check($options = array()) {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('CHECK TABLE ' . $this->tabela . ' ' . implode(' ', $options))->execute();
    }

    /**
     * 
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function checksum($options = array()) {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('CHECKSUM TABLE ' . $this->tabela . ' ' . implode(' ', $options))->execute();
    }

    /**
     * 
     * função que exclui a tabela do banco de dados
     * 
     * @return boolean
     */
    public function repair() {
        $this->_cache->deleteAll();
        return (bool) $this->pdo->query('REPAIR TABLE ' . $this->tabela)->execute();
    }

}
