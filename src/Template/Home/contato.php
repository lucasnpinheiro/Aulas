<div class="col-xs-12 col-md-4"> </div>
<div class="col-xs-12 col-md-4">
<?php

echo $this->Form->create();
echo $this->Form->input('nome', ['type'=>'text', 'label' => 'Nome:', 'required' => true, 'autofocus' => true]);
echo $this->Form->input('email', ['type' => 'email', 'label' => 'Email:', 'required' => true]);
echo $this->Form->input('assunto', ['type'=>'text', 'label' => 'Assunto:', 'required' => true]);
echo $this->Form->input('conteudo', ['type' => 'textarea', 'label' => 'Conteudo:', 'required' => true]);
echo '<div class="text-center">' . $this->Form->button( '<i class="fa fa-envelope-o" aria-hidden="true"></i> Enviar', ['type' => 'submit', 'class'=>'btn btn-primary']). '</div>';
echo $this->Form->end();
?>
</div>

