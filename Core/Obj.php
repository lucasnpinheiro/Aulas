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
class Obj extends \ArrayObject {

    /* public function __construct($input = null, $flags = self::ARRAY_AS_PROPS, $iterator_class = "ArrayIterator") {
      foreach ($input as $k => $v)
      $this->__set($k, $v);
      return $this;
      } */

    public function __construct($input = [], $flags = 0, $iterator_class = "ArrayIterator") {
        parent::__construct($input, $flags, $iterator_class);
    }

    public function __set($name, $value) {
        debug($name);
        exit;
        if (is_array($value) || is_object($value))
            //$this->offsetSet($name, (new self($value)));
            $this->offsetSet($name, $value);
        else
            $this->offsetSet($name, $value);
    }

    public function __get($name) {
        if ($this->offsetExists($name))
            return $this->offsetGet($name);
        elseif (array_key_exists($name, $this)) {
            return $this[$name];
        } else {
            throw new \InvalidArgumentException(sprintf('$this have not prop `%s`', $name));
        }
    }

    public function __isset($name) {
        return array_key_exists($name, $this);
    }

    public function __unset($name) {
        unset($this[$name]);
    }

    /*
      public function offsetSet($offset, $value) {
      if (is_null($offset)) {
      $this->itens[] = $value;
      } else {
      $this->itens[$offset] = $value;
      }
      }

      public function offsetExists($offset) {
      return isset($this->itens[$offset]);
      }

      public function offsetUnset($offset) {
      unset($this->itens[$offset]);
      }

      public function offsetGet($offset) {
      return isset($this->itens[$offset]) ? $this->itens[$offset] : null;
      } */
}
