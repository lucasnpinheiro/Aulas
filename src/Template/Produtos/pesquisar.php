<?php

echo $this->Form->create();
echo $this->Form->input('pesquisar', ['type' => 'text', 'value' => $this->request->query('pesquisar')]);
echo $this->Form->button('Pesquisar');
echo $this->Form->end();

//debug($produtos);

if (!empty($produtos))
{
    echo '<ul>';
    foreach ($produtos as $key => $value)
    {
        echo $this->Html->br(1);
        echo '<div style="font-size: 20px; color:blue"> ' . $value->nome . '<div style="font-size: 20px; color:red"> ' . $this->Html->moeda($value->venda) . ' ' . $this->Html->link('Detalhes', ['action' => 'detalhes', $value->id]) . ' ' . $this->Html->link('Comprar', ['controller' => 'Carrinho', 'action' => 'adicionar', $value->id]) . ' </div>';
    }
    echo '</ul>';
}


