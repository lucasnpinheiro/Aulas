<?php

namespace App\Controller;

use App\Controller\AppController;

class HomeController extends AppController {

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Clientes');
    }

    public function index() {
        $this->set('titulo', 'Bem vindo a loja Virtual - Calefi.com');
        $this->loadModel('Produtos');


        $consultar = $this->Produtos->limit(6)->order('RAND()', '')->all();
        // mandando a variavel para a view
        $this->set('produtos', $consultar);
        //$this->pagination('Produtos', $consultar, $this->totalRegistro); 
    }

    public function _remap() {
        echo '_remap';
    }

    public function add() {
        if ($this->request->isMethod('post')) {
            $dados = [
                'nome' => 'Teste1.txt',
                'data_nascimento' => '03/07/1984'
            ];

            if ($this->Clientes->save($dados)) {
                $this->redirect('index');
            } else {
                debug($this->Clientes->validacao_error);
            }
            echo 'Fazer Casdastro';
        }
    }

    public function edit($id = null) {
        if (!$this->Clientes->existe($id)) {
            debug('Erro registro não localizado');
            exit;
        }
        if ($this->request->isMethod('post')) {
            $dados = [
                'id' => $id,
                'nome' => 'Teste1.txt',
                'data_nascimento' => '03/07/1984'
            ];

            if ($this->Clientes->save($dados)) {
                $this->redirect('index');
            } else {
                debug($this->Clientes->validacao_error);
            }
            echo 'Fazer Alteração';
        }
    }

    public function delete($id = null) {
        if (!$this->Clientes->existe($id)) {
            debug('Erro registro não localizado');
            exit;
        }
        if ($this->request->isMethod('get')) {
            if ($this->Clientes->delete($id)) {
                $this->redirect('index');
            }
            echo 'Fazer Exclusão';
        }
    }

    public function login() {
        if ($this->request->isPost()) {
            if ($this->Auth->login($this->request->data)) {
                $this->redirect('/painel/Clientes/');
            } else {
                $this->session->setFlash('Erro ao fazer login.', 'danger');
            }
        }
    }

    public function logout() {
        $this->session->end();
        $this->redirect('/');
    }
    
   public function contato() {
        if ($this->request->isPost()) {
            // instanciando a classe de email
            $email = new \Core\Mail();

//debug($this->request->data);
//exit;
            $default = [
                'from' => [
                    'mail' => 'fercalefi@gmail.com',
                    'title' => 'Contato site aula',
                ],
                'add' => [$this->request->data('email')],
                'title' => 'Contatos site aula',
                'data' => $this->request->data,
            ];

            if ($email->send($default)) {
                $this->session->setFlash('Email enviado com sucesso!', 'success');
            } else {
                $this->session->setFlash('Erro ao enviar email!', 'danger');
            }
        }
    }

}
