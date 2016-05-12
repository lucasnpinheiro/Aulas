<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class PedidosController extends PainelAppController {

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Pedidos');
    }

    public function index() {
        $this->loadComponent('Search');
        $this->Search->prepare();
        $this->Pedidos->search();

        $consultas = $this->Pedidos->where('status', 9, '!=')->order('data_cadastro', 'desc')->contain(['Clientes', 'FormaPagto']);
        $this->pagination('Pedidos', $consultas, $this->totalregistro);
        $this->set('titulo', 'Lista de Pedidos');
    }

    public function alterar($id) {
        if ($this->request->isMethod('post')) {
            //pega o status anterior
            $pedido = $pedidoAtual = $this->Pedidos->findById($id);
            if ($this->Pedidos->save($this->request->data)) {
                $pedido = $this->Pedidos->contain(['Clientes'])->findById($id);
                // envio de email inicio
                if ($pedidoAtual->status != $pedido->status) {
                    if ($this->enviarEmail($pedido)) {
                        $this->session->setFlash('Email enviado com sucesso!', 'success');
                    } else {
                        $this->session->setFlash('Erro ao enviar email!', 'danger');
                    }
                }
                // envio de email fim    

                $this->session->setFlash('Registro Alterado com Sucesso', 'success');
                $this->redirect(['action' => 'index']);
            } else {
                $erro = [];
                foreach ($this->Pedidos->validacao_error as $key => $value) {
                    $erro[$key] = $key . '<br> - ' . implode('<br> - ', $value);
                }
                $this->session->setFlash(implode('<br>', $erro), 'danger');
            }
            $this->request->setData($pedido);
        }
        $this->loadModel('Clientes');
        $pedido = $this->Pedidos->findById($id);
        $this->request->setData($pedido);

        $this->set('cliente', $this->Clientes->findById($pedido->cliente_id));
        $this->set('titulo', 'Alterar Pedidos');




        // exit;              
    }

    public function excluir($id) {
        //$this->loadModel('PedidosItens');
        //$this->PedidosItens->deleteAll(['pedido_id' => $id]);
        //$this->Pedidos->delete($id);
        $this->Pedidos->updateAll(['status' => 9], ['id' => $id]);
        $pedido = $this->Pedidos->contain(['Clientes'])->findById($id);
        $this->enviarEmail($pedido);
        $this->session->setFlash('Registro Excluido com Sucesso', 'success');
        $this->redirect(['action' => 'index']);
    }

    public function detalhes($id) {
        $this->set('pedidos', $this->Pedidos->where('id', $id)->contain(['Clientes', 'FormaPagto', 'PedidosItens' => ['contain' => ['Produtos']]])->find());
        $this->set('titulo', 'Detalhes do Pedido');
    }

    private function enviarEmail($pedido) {
        $email = new \Core\Mail();
        $default = [
            'from' => [
                'mail' => $pedido->Clientes->email, 'title' => 'Alteração pedido',
            ],
            'add' => $pedido->Clientes->email,
            'title' => 'Alteração pedido',
            'data' => [ 'nome' => $pedido->Clientes->nome,
                'email' => $pedido->Clientes->email,
                'assunto' => 'Alteração de status do pedido número ' . $pedido->id,
                'conteudo' => 'Status alterado para ' . $pedido->status_descricao]
        ];
        return $email->send($default);
    }

}
