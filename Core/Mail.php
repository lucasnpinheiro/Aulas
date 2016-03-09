<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

use Core\Configure;
use Core\Helpers\Helper;
use Core\Session;
use Core\Request;
use Core\Mail\PHPMailer;

/**
 * Description of Email
 *
 * @author lucas
 */
class Mail {

    /**
     *
     * Carrega a classe session
     * 
     * @var object 
     */
    public $session = null;

    /**
     *
     * Carrega a classe helper
     * 
     * @var object 
     */
    public $helpers = null;

    /**
     *
     * Carrega a classe request
     * 
     * @var object 
     */
    public $request = null;

    /**
     *
     * Dados foram gerados pelo controller
     * 
     * @var array 
     */
    public $data = [];

    /**
     * 
     * Recebe o todos os helper a ser instanciado. 
     *
     * @var array 
     */
    public $helper = [];
    public $error = [];

    /**
     * 
     * O conteudo total carregado para exibir na tela
     *
     * @var string 
     */
    public $conteudo = null;

    public function __construct() {
        $this->request = new Request();
        $this->session = new Session();
        $this->helpers = new Helper($this->request);
        $this->helper = [
            ['nome' => 'Html', 'class' => 'BootstrapHtmlHelper'],
            ['nome' => 'Form', 'class' => 'BootstrapFormHelper']
        ];
    }

    public function send($options, $type = 'default') {
        $config = Configure::read('Parametros.Email');
        $config = $config[$type];
        $mail = new PHPMailer(((bool) Configure::read('app.debug')));
        $mail->SMTPDebug = (int) $config['Debug'];
        $mail->isSMTP();
        $mail->Host = $config['Host'];
        $mail->SMTPAuth = (bool) $config['Auth'];
        $mail->Username = $config['Username'];
        $mail->Password = $config['Password'];
        $mail->SMTPAutoTLS = false;
        if ($config['AutoTls'] > 0) {
            $mail->SMTPSecure = $config['Secure'];
            $mail->SMTPAutoTLS = true;
        }
        $mail->Port = (int) $config['Port'];
        $mail->CharSet = $config['Charset'];
        
        //$mail->isSMTP();                                      // Set mailer to use SMTP
	//$mail->Host = 'smtp.appettosa.com.br';  	  		  // Specify main and backup server
	//$mail->SMTPAuth = true;                               // Enable SMTP authentication
	//$mail->Port = 587; 
	//$mail->Username = 'suporte@appettosa.com.br';      // SMTP username
	//$mail->Password = 'willian321';                     // SMTP password
	//$mail->From = ('suporte@appettosa.com.br');
	//$mail->FromName = $_POST['nome'];
        
        
        
        $default = [
            'from' => [
                'mail' => '',
                'title' => '',
            ],
            'add' => [],
            'replyto' => [],
            'cc' => [],
            'bcc' => [],
            'file' => [],
            'html' => true,
            'title' => '',
            'data' => [],
            'alt' => '',
            'layout' => 'default',
            'view' => 'default',
        ];

        $options = Hash::merge($default, $options);

        $options['add'] = Hash::merge([-1 => [$options['from']['mail'] => $options['from']['title']]], $options['add']);

        $mail->setFrom($config['Username'], $config['Name']);

        if (count($options['add'])) {
            foreach ($options['add'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $mail->addAddress($k, $v);
                    }
                } else {
                    $mail->addAddress($value);
                }
            }
        }

        if (count($options['replyto'])) {
            foreach ($options['replyto'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $mail->addReplyTo($k, $v);
                    }
                } else {
                    $mail->addReplyTo($value);
                }
            }
        }

        if (count($options['cc'])) {
            foreach ($options['cc'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $mail->addCC($k, $v);
                    }
                } else {
                    $mail->addCC($value);
                }
            }
        }

        if (count($options['bcc'])) {
            foreach ($options['bcc'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $mail->addBCC($k, $v);
                    }
                } else {
                    $mail->addBCC($value);
                }
            }
        }

        if (count($options['file'])) {
            foreach ($options['file'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        $mail->addAttachment($k, $v);
                    }
                } else {
                    $mail->addAttachment($value);
                }
            }
        }
        $mail->isHTML($options['html']);

        $this->data = $options['data'];
        $this->data['title'] = $options['title'];

        $this->loads();

        $this->render($options['view']);
        $options['body'] = $this->renderlayout($options['layout']);

        $mail->Subject = $options['title'];
        $mail->Body = $options['body'];
        $mail->AltBody = $options['alt'];

        try {
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $exception) {
            $this->error = $exception;
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
            return false;
        }
    }

    /**
     * Carrega os helpers que serão usados no sistema
     */
    private function loads() {
        if (count($this->helper) > 0) {
            foreach ($this->helper as $key => $value) {
                $exist = false;
                $class = 'Core\Helpers\\' . $value['class'];
                $class_name = ROOT . str_replace('\\', DS, $class) . '.php';
                $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
                if (file_exists($class_name)) {
                    $exist = true;
                } else {
                    $class = 'App\Helpers\\' . $value['class'];
                    $class_name = ROOT . str_replace('\\', DS, $class) . '.php';
                    $class_name = str_replace(DS . 'App' . DS, DS . 'src' . DS, $class_name);
                    if (file_exists($class_name)) {
                        $exist = true;
                    }
                }
                if ($exist === true) {
                    $this->{$value['nome']} = new $class($this->request);
                } else {
                    throw new Exception('Helper não localizado.');
                }
            }
        }
    }

    /**
     * 
     * exibe a view com os dados já populados
     * 
     * @throws \Exception
     */
    private function render($view) {
        $v = ROOT . 'src' . DS . 'Template' . DS . 'Email' . DS . $view . '.php';
        try {
            if (!file_exists($v)) {
                throw new \Exception('A View "' . $v . '" não localizada.', 500);
            }

            ob_start();
            extract($this->data);
            include $v;
            $this->conteudo = ob_get_contents();
            ob_clean();
        } catch (\Exception $exception) {
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
        }
    }

    /**
     * 
     * Carrega os layout junto com as views prontas para exibir na tela
     * 
     * @throws MyException
     */
    private function renderlayout($layout) {
        try {
            $v = ROOT . 'src' . DS . 'Template' . DS . 'Layouts' . DS . 'Email' . DS . $layout . '.php';
            if (!file_exists($v)) {
                throw new \Exception('O Layout "' . $v . '" não localizado.', 500);
            }

            ob_start();
            extract($this->data);
            include $v;
            $layout = ob_get_contents();
            ob_clean();
            return $layout;
        } catch (\Exception $exception) {
            $ex = new \Core\MyException();
            $ex->show_exception($exception);
        }
    }

}
