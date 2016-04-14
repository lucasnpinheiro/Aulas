<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// debug($produtos);

echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Codigo'),
            $this->Table->th('Nome'),
            $this->Table->th('Venda'),
            $this->Table->th('Qtde'),
            $this->Table->th('Total'),
            $this->Table->th('Ações'),
        ])
);
$tbody = '';
foreach ($produtos as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->codigo),
        $this->Table->td($value->nome),
        $this->Table->td($this->Html->moeda($value->venda)),
        $this->Table->td('<input value="' . $value->qtde . '" />'),
        $this->Table->td($this->Html->moeda($value->total)),
        $this->Table->td(
                $this->Html->link('Alterar', ['action' => 'alterar'], ['class' => 'bt-alterar btn btn-primary'])
                . $this->Html->link('Excluir', ['action' => 'excluir', $value->id], ['class' => 'btn btn-danger bt-excluir'])
        ),
            ], ['rel' => $value->id]);
}


echo $this->Table->tbody($tbody);
echo $this->Table->end();

echo $this->Html->h('Total: '.$this->Html->moeda($this->session->read('Carrinho.Total')),2,['class'=>'col-md-4 text-center']);
echo $this->Html->h('Itens: '.$this->session->read('Carrinho.Qtde'),2,['class'=>'col-md-4 text-center']);
echo $this->Html->h('Volumes: '.$this->session->read('Carrinho.Volume'),2,['class'=>'col-md-4 text-center']);

echo $this->Form->create(['action'=>'salvar']);

echo $this->Form->input('formas',['type'=>'select','options'=>$formas]);
echo $this->Form->button('Gravar', ['type' => 'submit']);
echo $this->Form->end();

