<?php

echo $this->Form->create();
echo $this->Form->input('username',['type'=>'text']);
echo $this->Form->input('senha',['type'=>'password']);
echo $this->Form->button('Logar');
echo $this->Form->end();


