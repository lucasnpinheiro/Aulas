<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Session
 *
 * @author lucas
 */
class Session extends App {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->start();
    }

    public function start() {
        if (!session_id()) {
            session_start();
        }
    }

    public function read($key = null, $default = null) {
        $this->start();
        if (is_null($key)) {
            return $_SESSION;
        }
        if(!is_string($key)){
            $key = self::arrayImplode($key);
        }
        debug($key);
        $s = self::search($key, $_SESSION);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    public function write($value = null) {
        $this->start();
        if (empty($value)) {
            return null;
        }
        if (!is_array($value)) {
            $value = array($value);
        }
        $_SESSION = array_merge_recursive($value, $_SESSION);
    }

    public function destroy() {
        unset($_SESSION);
        session_destroy();
        $this->start();
    }

}
