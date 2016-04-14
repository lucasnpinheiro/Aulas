<?php

echo $this->Form->create();
echo $this->Form->input('nome', ['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Nome','type'=>'text']);
echo $this->Form->input('cpf',  ['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Cpf','type'=>'text']);
echo $this->Form->input('fone', ['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Fone','type'=>'text']);
echo $this->Form->input('email',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Email','type'=>'text']);
echo $this->Form->input('senha',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Senha','type'=>'password']);
echo $this->Form->button('Gravar',['type'=>'submit']);

echo $this->Form->end();
