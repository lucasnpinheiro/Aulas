<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Core\Session;

/**
 * Description of ClientesController
 *
 * @author Admin
 */
class ClientesController extends AppController {

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);

        $this->loadModel('Clientes');
    }

    //put your code here

    public function cadastrar() {


        if ($this->request->isMethod('post')) {

            // debug($this->request->data);

            $salvar = $this->Clientes->save($this->request->data);

            if ($salvar) {
                $this->request->redirect('/clientes/cadastrar');
            } else {
                debug($this->Clientes->validacao_error);
            }
            exit;
        }
    }

    public function recuperar_senha() {
        
    }

    public function login() {
        //debug($this->request->data);
        if ($this->request->isMethod('post')) {

            // debug($this->request->data);

            $consultar = $this->Clientes->findByEmailAndSenha($this->request->data['email'], $this->request->data['senha']);

            if ($consultar) {
                //$this->request->redirect('/clientes/cadastrar');
                Session::write('User', $consultar);
            } else {
                debug($this->Clientes->validacao_error);
            }
            // exit;
        }
        debug(Session::read('User'));
    }

}
