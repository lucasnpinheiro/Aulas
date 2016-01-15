<?php

echo $this->Form->create();
echo $this->Form->input('email', array('type' => 'email', 'label' => 'E-mail'));
echo $this->Form->button('Enviar', array('type' => 'submit'));
echo $this->Form->end();
?>