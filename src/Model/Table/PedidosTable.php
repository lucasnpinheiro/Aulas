<?php

namespace App\Model\Table;

use Core\Database\Table;

class PedidosTable extends Table {

    public $classe = 'PedidosEntity';
    public $tabela = 'pedidos';

    public function __construct() {
        parent::__construct();

    }
}
