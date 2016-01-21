<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;

/**
 * Description of ClientesController
 *
 * @author Admin
 */
class ClientesController extends AppController
{

    public function __construct()
    {
        parent::__construct();

        $this->loadTable('Clientes');
    }

    //put your code here

    public function cadastrar()
    {


        if ($this->request->isMethod('post'))
        {
            
            debug($this->request->data);
            
            $salvar = $this->Clientes->save($this->request->data);
            
            if ($salvar)
            {
                
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
        
    }

}
