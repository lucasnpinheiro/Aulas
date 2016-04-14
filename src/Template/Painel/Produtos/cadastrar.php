<?php

echo $this->Form->create(null,['type'=>'file']);
echo $this->Form->input('codigo',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Código','type'=>'text']);
echo $this->Form->input('nome',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Nome','type'=>'text']);
echo $this->Form->input('venda',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Venda','type'=>'text']);
echo $this->Form->input('estoque',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Estoque','type'=>'text']);
echo $this->Form->input('foto',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Caminho da Foto','type'=>'file']);
echo $this->Form->input('descricao_produto',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Descritivo','type'=>'text']);
echo $this->Form->button('Gravar',['type'=>'submit']);

echo $this->Form->end();
