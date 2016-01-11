<?php

namespace Core;

use Core\Configure;

/**
 * Classe que gerencia as session do sistema
 *
 * @author Lucas Pinheiro
 */
class Session extends App {

    /**
     * 
     * Função de auto execução ao startar a classe.
     * 
     */
    public function __construct() {
        if ($this->is_session_started()) {
            $this->_create();
        }
        if ($this->isRegistered()) {
            if ($this->isExpired()) {
                $this->renew();
            }
        } else {
            $this->register();
        }
    }

    /**
     * Destructor.
     */
    public function __destruct() {
        unset($this);
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
        $_SESSION = array_merge_recursive($_SESSION, self::setFindArray($key, $value));
    }

    /**
     * Le dados que estão na sessão
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function read($key = null, $default = null) {
        if(!$key){
            return $_SESSION;
        }
        $s = self::findArray($key, $_SESSION);
        return isset($s) ? $s : $default;
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
        $_SESSION = array();
        session_destroy();
        $this->_create();
    }

    private function _create() {
        $c = new Configure();
        $c->load('session');
        foreach (Configure::read('session') as $key => $value) {
            ini_set('session.' . $key, (is_int($value) ? (int) $value : (string) $value));
        }
        session_start();
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
                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {
                return session_id() === '' ? FALSE : TRUE;
            }
        }
        return FALSE;
    }

}
