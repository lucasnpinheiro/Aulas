<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class ProdutosController extends PainelAppController
{

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Produtos');
    }

    public function index()
    {

        $this->loadComponent('Search');
        $this->Search->prepare();
        $this->Produtos->search();

        // a linha abaixo é mesma coisa que as duas mais abaixo      
        // $this->set('consultas', $this->Usuarios->all());
        $consultas = $this->Produtos->order('nome', 'asc');
        $this->pagination('Produtos', $consultas, $this->totalregistro);
        $this->set('titulo', 'Lista de Produtos');
    }

    public function cadastrar()
    {
        if ($this->request->isMethod('post'))
        {
            $foto = $this->Produtos->upload($this->request->file['foto']);
            if ($foto)
            {
                $this->request->data['foto'] = $foto;
            }
            if ($this->Produtos->save($this->request->data))
            {
                $this->session->setFlash('Registro Gravado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Produtos->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->set('titulo', 'Cadastrar Produto');
    }

    public function alterar($id)
    {
        if ($this->request->isMethod('post'))
        {

            $foto = $this->Produtos->upload($this->request->file['foto']);
            if ($foto)
            {
                $this->request->data['foto'] = $foto;
                $this->Produtos->removeFoto($id);
            }

            if ($this->Produtos->save($this->request->data))
            {
                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else
            {
                $erro = [];
                foreach ($this->Produtos->validacao_error as $key => $value)
                {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
        }
        $this->request->setData($this->Produtos->findById($id));
        $this->set('titulo', 'Alterar Produto');
    }

    public function excluir($id)
    {
        $this->Produtos->delete($id);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

}
