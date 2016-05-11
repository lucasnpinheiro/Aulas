<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class FormasPagamentosController extends PainelAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('FormasPagamentos');
    }

    public function index()
    {
        // rotina de busca. Ler o componente 'search'
        $this->loadComponent('Search');
        $this->Search->Prepare();
        $this->FormasPagamentos->search();
        
        $consultas = $this->FormasPagamentos->order('nome', 'asc');
        //$this->set('consultas', $consultas);
        $this->set('titulo', 'Formas de pagamento');
        $this->pagination('FormasPagamentos', $consultas, $this->totalRegistro);
    }

    public function cadastrar()
    {

        if ($this->request->isMethod('post'))
        {
            if ($this->FormasPagamentos->save($this->request->data))
            {
                $this->session->setFlash('Registro Gravado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->FormasPagamentos->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->set('titulo', 'Cadastro de Formas de pagamento');
    }

    public function alterar($id)
    {
        if ($this->request->isMethod('post'))
        {
            if ($this->FormasPagamentos->save($this->request->data))
            {
                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->FormasPagamentos->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->request->setData($this->FormasPagamentos->findById($id));
        $this->set('titulo', 'Alteração de Formas de pagamento');
    }

    public function excluir($id)
    {
        $this->FormasPagamentos->delete($id);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

}
