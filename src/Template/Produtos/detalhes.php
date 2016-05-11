<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $detalhes->nome; ?></h3>
    </div>
    <div class="panel-body">
        <?php
        echo $detalhes->descricao_produto;
        echo $this->Html->br(2);
        echo 'Código: <span class="label label-info">' . $detalhes->codigo . '</span>';
        echo $this->Html->br(2);
        echo $this->Html->image($detalhes->url);
        echo '<div class="text-right" style="font-size: 60px; color:red"> ' . $this->Html->moeda($detalhes->venda) . '</div>';
        ?>
    </div>
</div>