<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo '<div style="font-size: 40px; color:blue"> '.$detalhes->nome; ?></h3>
    </div>
    <div class="panel-body">
        <?php
        echo '<div style="font-size: 20px; color:blue"> '.$detalhes->descricao_produto;
        echo $this->Html->br(2);
        echo 'Código: <span class="label label-info">' . $detalhes->codigo . '</span>';
        echo $this->Html->br(2);
        echo '<div class="text-left" style="font-size: 60px; color:red"> ' . $this->Html->moeda($detalhes->venda) . '</div>';
        ?>
    </div>
</div>
<?php ?>


