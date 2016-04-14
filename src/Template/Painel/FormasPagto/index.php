
<?php

echo $this->Form->create(null);
echo $this->Form->input('nome',['type'=>'text','placeholder'=>'Nome','div'=>['class'=>'col-xs-12 col-md-5']]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();
echo '<div class="clearfix"></div>';

echo $this->Html->link('Cadastrar',['action'=>'cadastrar'],['class'=>'btn btn-success']);
echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Nome'),
            $this->Table->th('Ações'),
        ])
);
$tbody = '';
foreach ($formas_pagto as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->nome),
        $this->Table->td(
                $this->Html->link('Alterar',['action'=>'alterar',$value->id],['class'=>'btn btn-primary'])
                . $this->Html->link('Excluir',['action'=>'excluir',$value->id],['class'=>'btn btn-danger bt-excluir'])
                ),
    ]);
}
echo $this->Table->tbody($tbody);
echo $this->Table->end();
echo $this->Pagination->run();



