<?php

namespace Core\Database;

use Core\Inflector;

/**
 * Classe que realiza o Entity dos dados que vem do banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Entity {

    /**
     * variavel que quarda os dados que foram setados na classe obejct
     * 
     * @var array 
     */
    private $_entity = array();

    /**
     * 
     * função que faz o tratamento dos dados a serém setados.
     * 
     */
    public function _setEntity($dados = array()) {
        if (count($dados) > 0) {
            foreach ($dados as $key => $value) {
                $this->{$key} = $value;
                $this->_entity[$key] = $this->{$key};
                $name = 'set' . Inflector::camelize($key);
                if (method_exists($this, $name)) {
                    $this->{$name}($value);
                }
                $name = 'get' . Inflector::camelize($key);
                if (method_exists($this, $name)) {
                    $this->_entity[$key] = $this->{$name}();
                }
            }
        }
    }

    /**
     * 
     * função que retorna os dados.
     * 
     * @return array
     */
    public function _getEntity() {
        return $this->_entity;
    }

}
