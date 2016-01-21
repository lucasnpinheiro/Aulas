<?php

namespace App\Model\Table;

use Core\Database\Table;

class FormasPagamentosTable extends Table {

    public $classe = 'FormasPagamentosEntity';
    public $tabela = 'formas_pagamentos';

    public function __construct() {
        parent::__construct();

    }
}
