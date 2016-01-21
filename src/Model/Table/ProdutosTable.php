<?php

namespace App\Model\Table;

use Core\Database\Table;

class ProdutosTable extends Table {

    public $classe = 'ProdutosEntity';
    public $tabela = 'produtos';

    public function __construct() {
        parent::__construct();

    }
}
