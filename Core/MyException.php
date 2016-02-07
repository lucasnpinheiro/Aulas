<?php

namespace Core;

use Core\View;

/**
 * Extendendo e manupulação a classe de Exption padrão do PHP
 *
 * @author Lucas Pinheiro
 */
class MyException {

    public function __construct($ex) {
        $this->view(['retorno' => [
                'msg' => $ex->getMessage(),
                'code' => $ex->getCode(),
                'line' => $ex->getLine(),
                'trace' => $ex->getTrace()
            ]
        ]);
    }

    public function view($data) {
        $r = new View('error', 'error', $data);

        $helper = [
            ['nome' => 'Html', 'class' => 'HtmlHelper'],
            ['nome' => 'Form', 'class' => 'BootstrapFormHelper'],
            ['nome' => 'Table', 'class' => 'TableHelper']
        ];

        foreach ($helper as $key => $value) {
            $r->helpers->addHerper($value);
        }


        $r->cache = false;
        $r->loads();

        $r->dir = 'Error';
        $r->data = $data;
        $r->cache = false;
        $r->render();
        $r->renderlayout();
        exit;
    }

}
