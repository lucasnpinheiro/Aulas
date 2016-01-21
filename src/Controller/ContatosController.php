<?php

namespace App\Controller;

use App\Controller\AppController;

class ContatosController extends AppController
{

    //put your code here
    public function index()
    {
       $this->loadTable('Vendedores');
    //   $this->Vendedores->save(['nome'=>'Nome 04']);
    //   $find = $this->Vendedores->order('nome','desc')->where('nome','teresa','LIKE')->limit(0,2)->all();
    //   $find = $this->Vendedores->findByNomeOrDataCadastro('Teresa','2016-01-14 00:05:06');
    //   $find = $this->Vendedores->findCountByNomeOrDataCadastro('Teresa','2016-01-14 00:05:06');
    //   $find = $this->Vendedores->deleteAll();    
       debug($find);
       
    }

    
}
