<?php

echo $this->Form->create();
echo $this->Form->input('email', ['type' => 'email', 'label' => 'E-mail']);
echo $this->Form->button('Enviar', ['type' => 'submit']);
echo $this->Form->end();
?>