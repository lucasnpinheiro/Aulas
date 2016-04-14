<?php

echo $this->Form->create(null);
echo $this->Form->input('nome',['type'=>'text','placeholder'=>'Nome','div'=>['class'=>'col-xs-12 col-md-5']]);
echo $this->Form->input('username',['type'=>'text','placeholder'=>'UserName','div'=>['class'=>'col-xs-12 col-md-5']]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();
echo '<div class="clearfix"></div>';

echo $this->Html->link('Cadastrar',['action'=>'cadastrar'],['class'=>'btn btn-success']);
echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Nome'),
            $this->Table->th('UserName'),
            $this->Table->th('Data Cadastro'),
            $this->Table->th('Ações'),
        ])
);
$tbody = '';
foreach ($usuarios as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->nome),
        $this->Table->td($value->username),
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



