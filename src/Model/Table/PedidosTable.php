<?php

namespace App\Model\Table;

use Core\Database\Table;

class PedidosTable extends Table
{

    public $classe = 'PedidosEntity';
    public $tabela = 'pedidos';
    
    public $filterArgs = [
        'nome' => 'like',
        'data_cadastro' => 'like'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}
