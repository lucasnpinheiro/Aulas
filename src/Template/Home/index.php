<?php
echo $this->Html->h($titulo, 1, ['class' => 'bg-primary']);
//debug($produtos);
?>

<?php foreach ($produtos as $key => $value) { ?> 
    <div class="col-xs-12 col-md-4">
        <?php echo $this->Html->h($value->nome, 2, ['class' => 'bg-info text-center']); ?>    
        <br>
        <?php echo $this->Html->image($value->url) ?>
        <br>
        <?php echo '<div style="font-size: 40px; color:blue"> ' . $this->Html->moeda($value->venda) ; ?> </div>  
        <br>
        <?php echo $this->Html->link('+ detalhes', '/produtos/detalhes/' . $value->id, ['class'=>'btn btn-primary']); ?>  
    </div>
<?php } ?>
