<?php

echo $teste;
echo $this->Html->br(10);

echo $this->element('teste1');

echo $this->Html->br(10);
$this->session->end();
$this->session->write('aa.bb.cc.ss', 'bb');
$this->session->write('aa.bb.cc.sa', 'bb');
$this->session->write('aa.bb.cc.sr', 'ou');
$this->session->write('aa.bb.cc', 'bb');
debug($this->session->read());
debug($this->session->read('aa'));
debug($this->session->read('aa.bb'));
debug($this->session->read('aa.bb.cc'));
debug($this->session->read('aa.bb.cc.0'));
debug($this->session->read('aa.bb.cc.sr'));

echo $this->Html->br(10);

echo $this->Form->create();
echo $this->Form->input('email', array('type' => 'email', 'label' => 'E-mail'));
echo $this->Form->button('Enviar', array('type' => 'submit'));
echo $this->Form->end();
