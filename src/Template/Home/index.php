<?php

echo $teste;
echo'<br>';
echo'<br>';
echo'<br>';
echo'<br>';
echo'<br>';
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
echo'<br>';
echo'<br>';
echo $this->element('teste1');
$this->session->end();
$this->session->write('aa.bb.cc.ss', 'bb');
$this->session->write('aa.bb.cc.sa', 'bb');
$this->session->write('aa.bb.cc.sr', 'ou');
$this->session->write('aa.bb.cc', 'bb');
debug($this->session->read('aa.bb.cc.sr'));

echo $this->Form->create();
echo $this->Form->input('email', array('type' => 'email', 'label' => 'E-mail'));
echo $this->Form->button('Enviar', array('type' => 'submit'));
echo $this->Form->end();
?>