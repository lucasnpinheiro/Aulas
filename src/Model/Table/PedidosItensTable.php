<?php

namespace App\Model\Table;

use Core\Database\Table;

class PedidosItensTable extends Table {

    public $classe = 'PedidosItensEntity';
    public $tabela = 'pedidos_itens';

    public function __construct() {
        parent::__construct();

    }
}
