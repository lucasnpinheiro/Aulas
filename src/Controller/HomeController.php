<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author lucas
 */

namespace src\Controller;

use src\Controller\AppController;

class HomeController extends AppController {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadTable('Clientes');
        $this->Clientes->save(array(
            'nome' => 'Teste1.txt',
            'data_nascimento' => '03/07/1984',
        ));
        debug($this->Clientes->validacao_error);
        debug($this->Clientes->findByDataNascimento('1984-07-03'));
        //$this->Clientes->cache = false;
        debug($this->Clientes->findAllByDataNascimento('1984-07-03'));
        $this->set('teste', 'Este é o meu teste.');
    }

    public function _remap() {
        echo '_remap';
    }

}
