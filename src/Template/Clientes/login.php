<?php

echo $this->Form->create();
echo $this->Form->input('email',['type'=>'email','label'=>'Email:','required'=>true, 'autofocus'=>true]);
echo $this->Form->input('senha',['type'=>'password','label'=>'Senha:','required'=>true]);
echo $this->Form->button('Logar',['type'=>'submit']);
echo $this->Form->end();



