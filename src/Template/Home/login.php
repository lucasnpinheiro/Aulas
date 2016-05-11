<div class="col-xs-12 col-md-4"> </div>
<?php
  echo $this->Form->create(); 
?>
  <div class="col-xs-12 col-md-4" style="height: 475px;">
<?php
  echo $this->Form->input('username',['type'=>'text', 'label' => 'Usuário']);
  echo $this->Form->input('senha',['type'=>'password', 'label' => 'Senha']);
  echo $this->Form->button('Logar');
?>
  </div>
<?php
echo $this->Form->end();


