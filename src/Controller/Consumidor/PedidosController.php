<?php

namespace App\Controller\Consumidor;

use App\Controller\Consumidor\ConsumidorAppController;

class PedidosController extends ConsumidorAppController {

    //put your code here
    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);
        $this->loadModel('Pedidos');
    }

    public function index() {
        $this->loadComponent('Search');
        $this->Search->prepare();
        $this->Pedidos->search();

        $consultas = $this->Pedidos->where('status', 9, '!=')->order('data_cadastro', 'desc')->where('cliente_id', $this->Auth->user('id'))->contain(['FormaPagto']);
        $this->pagination('Pedidos', $consultas, $this->totalregistro);
        $this->set('titulo', 'Lista de Pedidos');
    }

    public function detalhes($id) {
        $this->set('pedidos', $this->Pedidos->where('id', $id)->contain(['FormaPagto', 'PedidosItens' => ['contain' => ['Produtos']]])->find());
        $this->set('titulo', 'Detalhes do Pedido');
    }

}
