<?php

/**
 * Description of UsuariosEntity
 *
 * @author lucas
 */

namespace Core;

class Entity extends App {

    private $_entity = array();

    public function _setEntity($dados = array()) {
        if (count($dados) > 0) {
            foreach ($dados as $key => $value) {
                $this->{$key} = $value;
                $this->_entity[$key] = $this->{$key};
                $name = 'set' . $this->toUpper($key);
                if (method_exists($this, $name)) {
                    $this->{$name}($value);
                }
                $name = 'get' . $this->toUpper($key);
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
