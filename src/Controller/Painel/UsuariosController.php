<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class UsuariosController extends PainelAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Usuarios');
    }

    public function index()
    {
        // a linha abaixo é mesma coisa que as duas mais abaixo      
        // $this->set('consultas', $this->Usuarios->all());
        $consultas = $this->Usuarios->order('nome', 'asc')->order('username', 'asc')->all();
        $this->set('consultas', $consultas);
    }

    public function cadastrar()
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->Usuarios->save($this->request->data))
            {
                $this->session->setFlash('Registro Gravado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Usuarios->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
    }

    public function alterar($id)
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->Usuarios->save($this->request->data))
            {
                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Usuarios->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->request->setData($this->Usuarios->findById($id));
    }

    public function excluir($id)
    {
        $this->Usuarios->delete($id);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

}
