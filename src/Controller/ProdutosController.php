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
class ProdutosController extends AppController {

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);

        $this->loadModel('Produtos');
    }

    public function detalhes() {
        //debug($this->request->params[0]); 
        $consulta = $this->Produtos->findById($this->request->params[0]);
        // debug($consulta);
        $this->set('detalhes', $consulta);
    }

    public function pesquisar() {
        
        $this->loadComponent('Search');
        $this->Search->prepare();
        $this->loadModel('Produtos');
        $this->Produtos->search();

        $consultas = $this->Produtos->order('nome', 'asc');
        $this->pagination('Produtos', $consultas, $this->totalRegistro);
    }

}
