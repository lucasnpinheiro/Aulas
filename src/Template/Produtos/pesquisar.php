<?php

echo $this->Form->create();
echo $this->Form->input('pesquisar', ['type'=>'text', 'value'=>$this->request->query('pesquisar')]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();

//debug($produtos);
/*
if (!empty($produtos)){
    echo '<ul>';
    foreach ($produtos as $key => $value) {
        echo '<li> '.$value->nome.' '.$this->Html->moeda($value->venda). ' '.
                $this->Html->link('Detalhes', ['action'=>'detalhes', $value->id]).' '.$this->Html->link('Comprar',['controller'=>'carrinho', 'action'=>'adicionar', $value->id]).' </li>';
        
    }
    echo '</ul>';
}
*/

/*
echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Código'),
            $this->Table->th('Nome'),
            $this->Table->th('Preço'),
            $this->Table->th('Ações')
        ])
);
$tbody = '';
foreach ($produtos as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->codigo),
        $this->Table->td($value->nome),
        $this->Table->td($this->Html->moeda($value->venda)),
        $this->Table->td(
                $this->Html->link('Detalhes',['action'=>'detalhes'],['class'=>'bt-alterar btn btn-primary'])
                . $this->Html->link('Comprar',['controller'=>'carrinho', 'action'=>'adicionar', $value->id],['class'=>'btn btn-alterar btn-primary'])
                ),
    ], ['rel' => $value->id]);
    
   
}
echo $this->Table->tbody($tbody);
echo $this->Table->end();
*/
?>  
<?php foreach ($produtos as $key => $value) { ?> 
    <div class="col-xs-12 col-md-4">
        <?php echo $this->Html->h($value->nome, 2, ['class' => 'bg-info text-center']); ?>    
        <br>
        <?php echo $this->Html->image($value->url); ?>  
        <br>
        <?php echo $this->Html->moeda($value->venda); ?>  
        <br>
        <?php echo $this->Html->link('+ detalhes', '/produtos/detalhes/' . $value->id, ['class'=>'btn btn-primary'])
        . $this->Html->link('Comprar',['controller'=>'carrinho', 'action'=>'adicionar', $value->id],['class'=>'btn btn-primary']); ?>  
    </div>
<?php } ?>


