<?php

echo $this->Form->create();
echo $this->Form->input('nome', ['type' => 'text', 'required' => true, 'autofocus' => true]);
echo $this->Form->input('cpf', ['type' => 'text', 'required' => true]);
echo $this->Form->input('fone', ['type' => 'text', 'required' => true]);
echo $this->Form->input('email', ['type' => 'email', 'required' => true]);
echo $this->Form->input('senha', ['type' => 'password', 'value' => '']);

echo $this->Form->button('Salvar', ['type' => 'submit']);
echo $this->Form->end();
