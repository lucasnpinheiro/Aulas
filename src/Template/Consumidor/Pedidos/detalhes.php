<?php

//debug($pedidos);

echo $this->Html->h('Pedido: '.$pedidos->id,3);
echo $this->Html->h('Forma Pagto: '.$pedidos->FormaPagto->nome,3);
echo '<br>';

echo '<div class="clearfix"></div>';
echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Produto'),
            $this->Table->th('Quantidade', ['class' => 'text-right']),
            $this->Table->th('Venda', ['class' => 'text-right']),
            $this->Table->th('Total', ['class' => 'text-right']),
        ])
);

//debug($pedidos);


$tbody = '';
// variavel usuario para paginacao minuscula do framework
foreach ($pedidos->PedidosItens as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->Produtos->nome),
        $this->Table->td($value->qtde, ['class' => 'text-right']),
        $this->Table->td($this->Html->moeda($value->venda), ['class' => 'text-right']),
        $this->Table->td($this->Html->moeda($value->total), ['class' => 'text-right']),
    ]);
}

echo $this->Table->tbody($tbody);
echo $this->Table->end();


