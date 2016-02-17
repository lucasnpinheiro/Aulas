
<?php

echo $this->Form->create();
echo $this->Form->input('id',['type'=>'hidden']);
echo $this->Form->input('nome',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Nome','type'=>'text']);
echo $this->Form->input('username',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'UserName','type'=>'text']);
echo $this->Form->input('senha',['value'=>'','div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Senha','type'=>'password']);
echo $this->Form->button('Alterar',['type'=>'submit']);

echo $this->Form->end();
