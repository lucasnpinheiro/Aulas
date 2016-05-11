<div class="col-xs-12 col-md-4" >

<?php

echo $this->Form->create();
echo $this->Form->status('status');
echo $this->Form->input('id',['type'=>'hidden']);
echo $this->Form->button('Salvar');
echo $this->Form->end();
//echo $cliente->nome;
?>
</div>
