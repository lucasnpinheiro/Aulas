<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class FormasPagtoController extends PainelAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('FormasPagto');
    }

    public function index()
    {
        $this->loadComponent('Search');  
        $this->Search->prepare();
        $this->FormasPagto->search();

        // a linha abaixo é mesma coisa que as duas mais abaixo      
        // $this->set('consultas', $this->Usuarios->all());
        $consultas = $this->FormasPagto->order('nome', 'asc');
        $this->pagination('FormasPagto',$consultas,$this->totalregistro);
        $this->set('titulo', 'Lista de Formas de Pagamento');
    }

    public function cadastrar()
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->FormasPagto->save($this->request->data))
            {
                $this->session->setFlash('Registro Gravado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->FormasPagto->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->set('titulo', 'Cadastrar Forma de Pagamento');
    }

    public function alterar($id)
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->FormasPagto->save($this->request->data))
            {
                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->FormasPagto->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->request->setData($this->FormasPagto->findById($id));
        $this->set('titulo', 'Alterar Forma de Pagamento');
    }

    public function excluir($id)
    {
        $this->FormasPagto->delete($id);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

}
