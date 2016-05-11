<?php
echo $this->Form->create(NULL);
echo $this->Form->input('nome', ['type' => 'text', 'placeholder' => 'Digite a forma de pagamento:', 'div' => ['class' => 'col-xs-12 col-md-5']]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();

echo $this->Html->br();
echo $this->Html->br();

echo $this->Html->link('Cadastrar',['action'=>'cadastrar'],['class'=>'btn btn-success']);
echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Nome'),
            $this->Table->th('Data Cadastro'),
            $this->Table->th('Ações'),
        ])
);
$tbody = '';
foreach ($formas_pagamentos as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->nome),
        $this->Table->td($this->Html->data($value->data_cadastro)),
        $this->Table->td(
                $this->Html->link('Alterar',['action'=>'alterar',$value->id],['class'=>'btn btn-primary'])
                . $this->Html->link('Excluir',['action'=>'excluir',$value->id],['class'=>'btn btn-danger bt-excluir'])
                ),
    ]);
}
echo $this->Table->tbody($tbody);
echo $this->Table->end();
echo $this->Pagination->run();



