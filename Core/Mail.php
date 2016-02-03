<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

use Core\Configure;
use Core\Mail\PHPMailer;

/**
 * Description of Email
 *
 * @author lucas
 */
class Mail
{

    public function __construct()
    {
        $c = new Configure();
        $c->load('mail');
    }

    public function send($options, $type = 'default')
    {
        $config = Configure::read('mail');
        $config = $config[$type];
        $mail = new PHPMailer();
        $mail->SMTPDebug = $config['debug'];
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = $config['auth'];
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['secure'];
        $mail->Port = $config['port'];
        $mail->CharSet = $config['charset'];

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
            'body' => '',
            'alt' => '',
        ];

        $options = array_merge($default, $options);

        $options['add'] = array_merge([-1 => [$options['from']['mail'] => $options['from']['title']]], $options['add']);

        $mail->setFrom($config['username'], $config['name']);

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
        $mail->isHTML($options['html']);                                  // Set email format to HTML

        $mail->Subject = $options['title'];
        $mail->Body = $options['body'];
        $mail->AltBody = $options['alt'];

        try {
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (\Exception $exc) {
            debug($exc);
            return false;
        }
    }
}
