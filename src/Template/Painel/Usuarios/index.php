<?php

echo $this->Table->create(['class' => 'table table-striped table-hover cabecalho-tabela']);
echo $this->Table->thead(
        $this->Table->tr([
            $this->Table->th('Nome'),
            $this->Table->th('UserName'),
            $this->Table->th('Data Cadastro'),
        ])
);
$tbody = '';
foreach ($consultas as $key => $value)
{
    $tbody .= $this->Table->tr([
        $this->Table->td($value->nome),
        $this->Table->td($value->username),
        $this->Table->td($this->Html->data($value->data_cadastro)),
    ]);
}
echo $this->Table->tbody($tbody);
echo $this->Table->end();



