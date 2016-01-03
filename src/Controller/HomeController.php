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
        /* $find = $this->Clientes
          ->from('nome AS meu_nome')
          ->where('nome', 'Teste1.txt')
          ->orWhere('nome', 'Teste\'2.txt', 'like')
          ->orWhere('nome', 'Teste3.txt')
          ->group('nome')
          ->order('id', 'desc')
          ->all(); */
        $find = $this->Clientes
                ->query('SELECT * FROM clientes AS Cliente INNER JOIN contatos as Contato ON Cliente.id = Contato.cliente_id');
        debug($find);
        //$this->Clientes->cache = false;
        //debug($this->Clientes->findAllByDataNascimento('1984-07-03'));
        $this->set('teste', 'Este é o meu teste.');
        //$this->cache = true;
    }

    public function _remap() {
        echo '_remap';
    }

}
