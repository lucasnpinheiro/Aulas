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
        if (is_null($key)) {
            return $_SESSION;
        }
        $s = self::search($key, $_SESSION);
        if (is_null($s)) {
            return $default;
        }
        return $s;
    }

    public function write($name, $value = null) {
        $_SESSION = array();
        $a = (isset($_SESSION) ? $_SESSION : array());
        $_SESSION = self::setSearch(explode('.', $name), $value, $a);
    }

    public function destroy() {
        unset($_SESSION);
        session_destroy();
    }

    public function delete($key) {
        $s = self::setSearch($key);
        unset($s);
    }

}
