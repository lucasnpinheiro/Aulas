<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;

/**
 * Description of CarrinhoController
 *
 * @author Admin
 */
class CarrinhoController extends AppController
{

    //put your code here
    public function adicionar($id)
    {
        $total = $this->session->read('Carrinho.Itens');

        if (!empty($total[$id]))
        {
            $total[$id] += 1;
        } else
        {
            $total[$id] = 1;
        }

        $this->session->write('Carrinho.Itens', $total);
        $this->session->setFlash('Produtos Adicionados no Carrinho', 'success');
        $this->redirect($this->referer());
    }

    public function index()
    {
        $total = $this->session->read('Carrinho.Itens');
        if (count($total) > 0)
        {
            $this->loadModel('Produtos');
            $this->loadModel('FormasPagto');
            $formas = $this->FormasPagto->combo();

            $produtos = $this->Produtos->where('id', array_keys($total))->all();

            $subtotal = $qtde = $volume = 0;

            foreach ($produtos as $key => $value)
            {
                $produtos[$key]->total = ($value->venda * $total[$value->id] );
                $produtos[$key]->qtde = $total[$value->id];
                $subtotal += $produtos[$key]->total;
                $qtde += $produtos[$key]->qtde;
                $volume++;
            }
            $this->session->write('Carrinho.Total', $subtotal);
            $this->session->write('Carrinho.Qtde', $qtde);
            $this->session->write('Carrinho.Volume', $volume);

            $this->set('produtos', $produtos);
            $this->set('formas', $formas);
        } else
        {
            $this->redirect(['controller' => 'produtos', 'action' => 'pesquisar']);
        }
        //    debug($produtos);
        //    exit;
    }

    public function excluir($id)
    {
        $total = $this->session->read('Carrinho.Itens');
        unset($total[$id]);
        $this->session->write('Carrinho.Itens', $total);
        $this->session->setFlash('Produto Removido Com Sucesso', 'success');
        $this->redirect($this->referer());
    }

    public function alterar($id, $qtde)
    {
        $total = $this->session->read('Carrinho.Itens');
        $qtde = (int) $qtde;
        if ($qtde > 0)
        {
            $total[$id] = (int) $qtde;
            $this->session->setFlash('Produto Alterado com Sucesso', 'success');
        } else
        {
            unset($total[$id]);
            $this->session->setFlash('Produto Removido do Carrinho', 'success');
        }
        $this->session->write('Carrinho.Itens', $total);
        $this->redirect($this->referer());
    }

    public function salvar()
    {
        if ($this->session->read('Auth.Clientes.id'))
        {

            $this->loadModel('Pedidos');
            $this->loadModel('PedidosItens');
            $this->loadModel('Produtos');
            $pedido = [
                'data_pedido' => date('Y-m-d'),
                "cliente_id" => $this->session->read('Auth.Clientes.id'),
                "total" => $this->session->read('Carrinho.Total'),
                "forma_pagto_id" => $this->request->data('formas'),
                "status" => 0,
            ];
            $pedido = $this->Pedidos->save($pedido);
            $total = $this->session->read('Carrinho.Itens');
            $produtos = $this->Produtos->where('id', array_keys($total))->all();

            foreach ($produtos as $key => $value)
            {
                $pedidoitens = [
                    'pedido_id' => $pedido->id,
                    'produto_id' => $value->id,
                    'qtde' => $total[$value->id],
                    'venda' => $value->venda,
                        //    'total' =>($total[$value->id]*$value->venda),
                ];
                $pedidoitens['total'] = ($pedidoitens['qtde'] * $pedidoitens['venda']);
                $this->PedidosItens->save($pedidoitens);

                // totaliza itens
                $totalitens['qtde'] = ($totalitens['qtde'] + 1);
                $totalitens = ['qtde' => $totalitens[$value->id]];
                $this->PedidosItens->save($totalitens);
            }
            $this->session->write('Carrinho', null);
            $this->redirect($this->referer());
        } else
        {
            $this->redirect('/clientes/login');
        }
    }

}
