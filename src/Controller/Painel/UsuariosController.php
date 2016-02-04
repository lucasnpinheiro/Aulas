<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class UsuariosController extends PainelAppController
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Usuarios');
    }

    public function index()
    {
        // a linha abaixo é mesma coisa que as duas mais abaixo      
        // $this->set('consultas', $this->Usuarios->all());
        $consultas = $this->Usuarios->order('nome','asc')->order('username','asc')->all();
        $this->set('consultas', $consultas);
    }

    public function cadastrar()
            {
        if ($this->request->isMethod('post')){
            $this->Usuarios->save($this->request->data);
            $this->redirect($this->referer());
        }
    }
}
