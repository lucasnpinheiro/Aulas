<?php

echo $this->Form->create();
echo $this->Form->input('nome',['required'=>true,'div'=>['class'=>'col-xs-12 col-md-4'],'label'=>'Nome','type'=>'text']);
echo $this->Form->button('Gravar',['type'=>'submit']);

echo $this->Form->end();


