<?php

namespace Core;

class Session extends App {

    /**
     * Constructor.
     */
    public function __construct() {
        if ($this->is_session_started()) {
            session_start();
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
     * Checks to see if the session is registered.
     *
     * @return  True if it is, False if not.
     */
    public function isRegistered() {
        if (!empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set key/value in session.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function write($key, $value) {
        $_SESSION = array_merge_recursive($_SESSION, self::setSearch($key, $value));
    }

    /**
     * Retrieve value stored in session by key.
     *
     * @var mixed
     */
    public function read($key, $default = null) {
        $s = self::search($key, $_SESSION);
        return isset($s) ? $s : $default;
    }

    /**
     * Retrieve the global session variable.
     *
     * @return array
     */
    public function getSession() {
        return $_SESSION;
    }

    /**
     * Gets the id for the current session.
     *
     * @return integer - session id
     */
    public function getSessionId() {
        return $_SESSION['session_id'];
    }

    /**
     * Checks to see if the session is over based on the amount of time given.
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
     * Renews the session when the given time is not up and there is activity on the site.
     */
    public function renew() {
        $_SESSION['session_start'] = $this->newTime();
    }

    /**
     * Returns the current time.
     *
     * @return unix timestamp
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
     * Generates new time.
     *
     * @return unix timestamp
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
     * Destroys the session.
     */
    public function end() {
        $_SESSION = array();
        //session_destroy();
    }

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
