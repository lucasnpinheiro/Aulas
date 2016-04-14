<?php

echo $this->Form->create(null);
echo $this->Form->input('data_pedido',['type'=>'date','placeholder'=>'UserName','div'=>['class'=>'col-xs-12 col-md-5']]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();
echo '<div class="clearfix"></div>';

echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('ID'),
            $this->Table->th('Data'),
            $this->Table->th('Total'),
            $this->Table->th('Situação'),
            $this->Table->th('Forma Pagamento'),
            $this->Table->th('Ações'),
        ])
);
$tbody = '';
foreach ($pedidos as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->id),
        $this->Table->td($this->Html->data($value->data_pedido)),
        $this->Table->td($value->total),
        $this->Table->td($this->Html->status($value->status)),
        $this->Table->td($value->FormaPagto->nome),
        $this->Table->td(
                $this->Html->link('Detalhes',['action'=>'detalhes',$value->id],['class'=>'btn btn-info'])
                ),
    ]);
}
echo $this->Table->tbody($tbody);
echo $this->Table->end();
echo $this->Pagination->run();



