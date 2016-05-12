
<div class="clientes form large-9 medium-8 columns content">
    <?=
    $this->Form->create();
    ?>
    <fieldset>
        <legend><?= 'Alterar Dados' ?></legend>
        <?php 
        echo $this->Form->input('nome', ['type' => 'text' , 'autofocus' => true ]);
        echo $this->Form->input('cpf', ['type' => 'text']);
        echo $this->Form->input('fone', ['type' => 'text']);
        echo $this->Form->input('email', ['type' => 'email']);
        echo $this->Form->input('senha', ['type' => 'password', 'value' => '']);
        ?>
    </fieldset>
        <?= $this->Form->button('Salvar', ['type' => 'Submit']) ?>
    <?= $this->Form->end() ?>
</div>




