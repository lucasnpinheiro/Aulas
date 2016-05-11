<div class="col-xs-12" style="margin-top: 150px"> </div>
<div class="col-xs-12 col-md-4"> </div>
<div class="col-xs-12 col-md-4">

    <?php
    echo $this->Form->create();
    echo $this->Form->input('email', ['type' => 'email', 'label' => 'Email:', 'required' => true, 'autofocus' => true]);
    echo $this->Form->input('senha', ['type' => 'password', 'label' => 'Senha:', 'required' => true]);

    echo '<div class="text-center">' . $this->Form->button('Logar', ['type' => 'submit', 'class'=>'btn btn-primary']) . '</div>';
    echo $this->Form->end();
    ?>
</div>
<div class="col-xs-12 col-md-4"> </div>
<div class="clearfix"> </div>