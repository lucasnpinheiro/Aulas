<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class ClientesController extends PainelAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Clientes');
    }

    public function index()
    {

        $this->loadComponent('Search');
        $this->Search->prepare();
        $this->Clientes->search();

        // a linha abaixo é mesma coisa que as duas mais abaixo      
        // $this->set('consultas', $this->Usuarios->all());
        $consultas = $this->Clientes->order('nome', 'asc');
        $this->pagination('Clientes', $consultas, $this->totalregistro);
        $this->set('titulo', 'Lista de Clientes');
    }

    public function cadastrar()
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->Clientes->save($this->request->data))
            {
                $this->session->setFlash('Registro Gravado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Clientes->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->set('titulo', 'Cadastrar Cliente');
    }

    public function alterar($id)
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->Clientes->save($this->request->data))
            {
                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Clientes->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->request->setData($this->Clientes->findById($id));
        $this->set('titulo', 'Alterar Cliente');
    }

    public function excluir($id)
    {
        $this->Clientes->delete($id);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

}
