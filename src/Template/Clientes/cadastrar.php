<?php

echo $this->Form->create();

echo $this->Form->input('nome',['label'=>'Nome:','required'=>true, 'autofocus'=>true]);
echo $this->Form->input('cpf',['label'=>'Cpf:','required'=>true]);
echo $this->Form->input('fone',['label'=>'Telefone:']);
echo $this->Form->input('email',['type'=>'email','label'=>'Email:','required'=>true]);
echo $this->Form->input('senha',['type'=>'password','label'=>'Senha:','required'=>true]);

echo $this->Form->button('Salvar',['type'=>'submit']);
echo $this->Form->end();



