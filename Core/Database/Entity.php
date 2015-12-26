<?php

/**
 * Description of UsuariosEntity
 *
 * @author lucas
 */

namespace Core\Database;

use Core\Inflector;

class Entity{

    private $_entity = array();

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

    public function _getEntity() {
        return $this->_entity;
    }

}
