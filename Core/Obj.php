<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Obj
 *
 * @author lucas
 */
class Obj implements \ArrayAccess {

    private $itens = array();

    public function offsetExists($offset) {
        return isset($this->itens[$offset]);
    }

    public function offsetGet($offset) {
        if (!$this->offsetExists($offset)) {
            $this->offsetSet($offset, new Obj());
        }

        return $this->itens[$offset];
    }

    public function offsetSet($offset, $value) {
        $this->itens[$offset] = $value;
    }

    public function offsetUnset($offset) {
        unset($this->itens[$offset]);
    }

    public function __get($name) {
        return $this->offsetGet($name);
    }

    public function __set($name, $value) {
        return $this->offsetSet($name, $value);
    }

    public function __isset($name) {
        return isset($this->itens[$name]);
    }

    public function __unset($name) {
        unset($this->itens[$name]);
    }

}
