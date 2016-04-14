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
class ClientesController extends AppController
{

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);

        $this->loadModel('Clientes');
    }

    //put your code here

    public function cadastrar()
    {


        if ($this->request->isMethod('post'))
        {

            // debug($this->request->data);

            $salvar = $this->Clientes->save($this->request->data);

            if ($salvar)
            {
                $this->request->redirect('/clientes/cadastrar');
            } else
            {
                debug($this->Clientes->validacao_error);
            }
            exit;
        }
    }

    public function recuperar_senha()
    {
        
    }

    public function login()
    {
        if ($this->request->isPost())
        {
            $this->Auth->setConfig('clientes');
            if ($this->Auth->login($this->request->data))
            {
                $this->redirect('/consumidor/clientes/alterar');
            } else
            {
                $this->session->setFlash('Erro ao Fazer Login', 'danger');
            }
        }
    }

    public function logout()
    {
        $this->session->end();
        $this->redirect('/');
    }

}
