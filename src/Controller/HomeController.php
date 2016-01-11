<?php

namespace App\Controller;

use App\Controller\AppController;

class HomeController extends AppController {

    public function __construct() {
        parent::__construct();
        $this->loadTable('Clientes');
    }

    public function index() {
        $this->set('teste', 'Esta é a pagina Inicial.');
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

}
