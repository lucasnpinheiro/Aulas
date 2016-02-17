<?php

ini_set('default_charset', 'UTF-8');
/* $serve_name = trim(str_replace(array('wwww'), '', $_SERVER['SERVER_NAME']), '.');
  if ($serve_name === 'betatest.appettosa.com' OR $serve_name === 'app.appettosa.com') {
  $explode = explode('.', $serve_name);
  $dir = $explode[0];
  unset($explode[0]);
  $explode = implode('.', $explode);
  header('location: http://' . $explode . '/' . $dir);
  } */

function debug($str) {
    echo '<div style="padding: 25px;">';
    echo '<pre style="color:black;">';
    $a = debug_backtrace();
    echo '<div style="color:red;"><strong>File: </strong>' . $a[0]['file'] . '</div>';
    echo '<div style="color:red;"><strong>Line: </strong>' . $a[0]['line'] . '</div>';
    if (isset($a[1]['class']) and ! empty($a[1]['class'])) {
        echo '<div style="color:red;"><strong>Class: </strong>' . $a[1]['class'] . '</div>';
    }
    if (isset($a[1]['function']) and ! empty($a[1]['function'])) {
        echo '<div style="color:red;"><strong>Function: </strong>' . $a[1]['function'] . '</div>';
    }
    var_dump($str);
    echo '</pre>';
    echo '</hr>';
    echo '</div>';
}

function pr($str) {
    echo '<div style="padding: 25px;">';
    echo '<pre style="color:black;">';
    $a = debug_backtrace();
    echo '<div style="color:red;"><strong>File: </strong>' . $a[0]['file'] . '</div>';
    echo '<div style="color:red;"><strong>Line: </strong>' . $a[0]['line'] . '</div>';
    if (isset($a[1]['class']) and ! empty($a[1]['class'])) {
        echo '<div style="color:red;"><strong>Class: </strong>' . $a[1]['class'] . '</div>';
    }
    if (isset($a[1]['function']) and ! empty($a[1]['function'])) {
        echo '<div style="color:red;"><strong>Function: </strong>' . $a[1]['function'] . '</div>';
    }
    print_r($str);
    echo '</pre>';
    echo '</hr>';
    echo '</div>';
}

function sanitize_output($buffer) {
    $search = [
        '/\>[^\S ]+/s', // strip whitespaces after tags, except space
        '/[^\S ]+\</s', // strip whitespaces before tags, except space
        '/(\s)+/s', // shorten multiple whitespace sequences*/
        '/<!--(.|\s)*?-->/', //strip HTML comments
        "/\n/s",
        "/\t/s",
        "/\r/s",
    ];
    $replace = [
        '>',
        '<',
        '\\1',
        '',
        '',
        '',
        '',
    ];
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__) . DS);
}

if (!defined('CORE')) {
    define('CORE', ROOT . 'Core' . DS);
}

if (!defined('VENDOR')) {
    define('VENDOR', ROOT . 'vendor' . DS);
}

if (!defined('APP')) {
    define('APP', ROOT . 'src' . DS);
}

if (!defined('WEBROOT')) {
    define('WEBROOT', 'webroot' . DS);
}

require_once ROOT . 'vendor/autoload.php';


if (!function_exists('set_status_header')) {

    /**
     * Set HTTP Status Header
     *
     * @param	int	the status code
     * @param	string
     * @return	void
     */
    function set_status_header($code = 200, $text = '') {
        if (is_cli()) {
            return;
        }

        if (empty($code) OR ! is_numeric($code)) {
            show_error('Status codes must be numeric', 500);
        }

        if (empty($text)) {
            is_int($code) OR $code = (int) $code;
            $stati = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported'
            );

            if (isset($stati[$code])) {
                $text = $stati[$code];
            } else {
                $ex = new Core\MyException();
                $ex->show_error('No status text available. Please check your status code number or supply your own message text.', 500);
            }
        }

        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header('Status: ' . $code . ' ' . $text, TRUE);
        } else {
            $server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
            header($server_protocol . ' ' . $code . ' ' . $text, TRUE, $code);
        }
    }

}

if (!function_exists('_error_handler')) {

    /**
     * Error Handler
     *
     * This is the custom error handler that is declared at the (relative)
     * top of CodeIgniter.php. The main reason we use this is to permit
     * PHP errors to be logged in our own log files since the user may
     * not have access to server logs. Since this function effectively
     * intercepts PHP errors, however, we also need to display errors
     * based on the current error_reporting level.
     * We do that with the use of a PHP error template.
     *
     * @param	int	$severity
     * @param	string	$message
     * @param	string	$filepath
     * @param	int	$line
     * @return	void
     */
    function _error_handler($severity, $message, $filepath, $line) {
        $is_error = (((E_ERROR | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);

        // When an error occurred, set the status header to '500 Internal Server Error'
        // to indicate to the client something went wrong.
        // This can't be done within the $_error->show_php_error method because
        // it is only called when the display_errors flag is set (which isn't usually
        // the case in a production environment) or when errors are ignored because
        // they are above the error_reporting threshold.
        if ($is_error) {
            set_status_header(500);
        }

        // Should we ignore the error? We'll get the current error_reporting
        // level and add its bits with the severity bits to find out.
        if (($severity & error_reporting()) !== $severity) {
            return;
        }

        $_error = new Core\MyException();
        // Should we display the error?
        if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors'))) {
            $_error->show_php_error($severity, $message, $filepath, $line);
        }

        // If the error is fatal, the execution of the script should be stopped because
        // errors can't be recovered from. Halting the script conforms with PHP's
        // default error handling. See http://www.php.net/manual/en/errorfunc.constants.php
        if ($is_error) {
            exit(1); // EXIT_ERROR
        }
    }

}

// ------------------------------------------------------------------------

if (!function_exists('_exception_handler')) {

    /**
     * Exception Handler
     *
     * Sends uncaught exceptions to the logger and displays them
     * only if display_errors is On so that they don't show up in
     * production environments.
     *
     * @param	Exception	$exception
     * @return	void
     */
    function _exception_handler($exception) {
        $_error = new Core\MyException();

        // Should we display the error?
        if (str_ireplace(array('off', 'none', 'no', 'false', 'null'), '', ini_get('display_errors'))) {
            $_error->show_exception($exception);
        }

        exit(1); // EXIT_ERROR
    }

}

// ------------------------------------------------------------------------

if (!function_exists('_shutdown_handler')) {

    /**
     * Shutdown Handler
     *
     * This is the shutdown handler that is declared at the top
     * of CodeIgniter.php. The main reason we use this is to simulate
     * a complete custom exception handler.
     *
     * E_STRICT is purposively neglected because such events may have
     * been caught. Duplication or none? None is preferred for now.
     *
     * @link	http://insomanic.me.uk/post/229851073/php-trick-catching-fatal-errors-e-error-with-a
     * @return	void
     */
    function _shutdown_handler() {
        $last_error = error_get_last();
        if (isset($last_error) &&
                ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))) {
            _error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

}

\Core\Configure::load('app');
$router = new Core\Router(new \Core\Request());
$router->run();
