<?php

namespace Core;

/**
 * Extendendo e manupulação a classe de Exption padrão do PHP
 *
 * @author Lucas Pinheiro
 */
class MyException {

    /**
     * Nesting level of the output buffering mechanism
     *
     * @var	int
     */
    public $ob_level;
    public $layout = 'error';
    public $helper = [];

    /**
     * List of available error levels
     *
     * @var	array
     */
    public $levels = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice'
    );

    /**
     * Class constructor
     *
     * @return	void
     */
    public function __construct() {
        $this->ob_level = ob_get_level();
        $this->helper = [
            ['nome' => 'Html', 'class' => 'BootstrapHtmlHelper'],
            ['nome' => 'Form', 'class' => 'BootstrapFormHelper']
        ];
        // Note: Do not log messages from this constructor.
    }

    private function render($veiw, $data) {
        $data['title'] = $data['heading'];
        $r = new View(new Request(), new Session, new Helpers\Helper(new Request()));
        $r->view = $veiw;
        $r->layout = $this->layout;
        $r->dir = 'Error' . DS . 'Html';
        $r->data = $data;
        if (count($this->helper) > 0) {
            foreach ($this->helper as $key => $value) {
                $r->helpers->addHerper($value);
            }
        }

        $r->loads();
        $r->render();
        $r->renderlayout();
        exit(4);
    }

    // --------------------------------------------------------------------

    /**
     * 404 Error Handler
     *
     * @uses	MyException::show_error()
     *
     * @param	string	$page		Page URI
     * @param 	bool	$log_error	Whether to log the error
     * @return	void
     */
    public function show_404($page = '', $log_error = TRUE) {
        $heading = '404 Page Not Found';
        $message = 'The page you requested was not found.';
        if ($log_error) {
            \Core\Log::write('error', $heading . ': ' . $page, '404');
        }
        $this->show_error($heading, $message, 'error_404', 404);
    }

    // --------------------------------------------------------------------

    /**
     * General Error Page
     *
     * Takes an error message as input (either as a string or an array)
     * and displays it using the specified template.
     *
     * @param	string		$heading	Page heading
     * @param	string|string[]	$message	Error message
     * @param	string		$template	Template name
     * @param 	int		$status_code	(default: 500)
     *
     * @return	string	Error page output
     */
    public function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
        $this->render($template, [
            'heading' => $heading,
            'message' => $message,
            'status_code' => $status_code,
        ]);
    }

    // --------------------------------------------------------------------

    public function show_exception($exception) {
        $message = $exception->getMessage();
        if (empty($message)) {
            $message = '(null)';
        }
        $this->render('error_exception', [
            'heading' => 'Exception',
            'exception' => $exception,
            'message' => $message
        ]);
    }

    // --------------------------------------------------------------------

    /**
     * Native PHP error handler
     *
     * @param	int	$severity	Error level
     * @param	string	$message	Error message
     * @param	string	$filepath	File path
     * @param	int	$line		Line number
     * @return	string	Error page output
     */
    public function show_php_error($severity, $message, $filepath, $line) {
        if (empty($message)) {
            $message = '(null)';
        }
        $this->render('error_php', [
            'heading' => 'Error handler',
            'severity' => $severity,
            'message' => $message,
            'filepath' => $filepath,
            'line' => $line
        ]);
    }

}
