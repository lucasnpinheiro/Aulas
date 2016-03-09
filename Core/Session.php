<?php

namespace Core;

use Core\Configure;

/**
 * Classe que gerencia as session do sistema
 *
 * @author Lucas Pinheiro
 */
class Session {

    use Traits\FuncoesTrait;

    /**
     * 
     * Função de auto execução ao startar a classe.
     * 
     */
    public function __construct() {
        $this->_create();

        if ($this->isRegistered()) {
            if ($this->isExpired()) {
                $this->renew();
            }
        } else {
            $this->register();
        }
    }

    /**
     * Register the session.
     *
     * @param integer $time.
     */
    public function register($time = 60) {
        $_SESSION['session_id'] = session_id();
        $_SESSION['session_time'] = intval($time);
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     * Verifica se a sessão esta registrada
     *
     * @return boolean
     */
    public function isRegistered() {
        if (!empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adiciona itens na sessão.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function write($key, $value) {
        $key = trim($key, '.');
        if (is_array($value) OR is_object($value)) {
            $value = json_decode(json_encode($value), true);
        }
        //$s = $_SESSION;
        $_SESSION = Hash::insert($_SESSION, $key, $value);
        //$_SESSION = array_merge($_SESSION, $s);
    }

    /**
     * Le dados que estão na sessão
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function read($key = null, $default = null) {
        if (!$key) {
            return $_SESSION;
        }
        $key = trim($key, '.');
        $s = Hash::get($_SESSION, $key);
        if (!is_array($s)) {
            return !isset($s) ? $default : (trim($s) === '' ? $default : $s);
        }
        return $this->forceBollean($s);
    }

    /**
     * Le dados que estão na sessão
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function delete($key) {
        $s = &$_SESSION;
        $ex = explode('.', $key);
        foreach ($ex as $k => $v) {
            if ($v == $key) {
                unset($s[$v]);
            }
            if (isset($s[$v])) {
                $s = $s[$v];
            }
        }
        //Hash::insert($_SESSION, $key, null);
        return true;
    }

    /**
     * Traz todos os dados da sessão.
     *
     * @return array
     */
    public function getSession() {
        return $_SESSION;
    }

    /**
     * retorna o ID da sessão
     *
     * @return integer
     */
    public function getSessionId() {
        return $_SESSION['session_id'];
    }

    /**
     * Verifica se a sessão Expirou
     *
     * @return boolean
     */
    public function isExpired() {
        if ($_SESSION['session_start'] < $this->timeNow()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Gera um novo tempo para a sessão
     */
    public function renew() {
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     * Formata os data para tepo de sessão.
     *
     * @return unix
     */
    private function timeNow() {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
    }

    /**
     * gera um novo tempo de vida da sessão
     *
     * @return unix
     */
    private function newTime() {
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear);
    }

    /**
     * Destroy a sessão
     */
    public function end() {
        $r = $this->read('flash', null);
        $_SESSION = [];
        if ($this->is_session_started()) {
            session_destroy();
            $this->_create();
        }
        if (!empty($r)) {
            $this->write('flash', $r);
        }
    }

    private function _create() {
        if ($this->is_session_started()) {
            Configure::load('session');
            foreach (Configure::read('session') as $key => $value) {
                ini_set($key, $value);
            }
        }
        @session_start();
    }

    /**
     * 
     * Verifica se a sessão foi carregada.
     * 
     * @return boolean
     */
    public function is_session_started() {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

    public function setFlash($value, $type = 'success') {
        $this->delete('flash');
        $dados = [
            'msg' => $value,
            'type' => $type,
        ];
        $this->write('flash', $dados);
        return true;
    }

    public function getFlash() {
        $r = $this->read('flash', null);
        $this->delete('flash');
        return $r;
    }

}
