<?php

namespace App\Model\Table;

use Core\Database\Table;

class FormasPagtoTable extends Table
{

    public $classe = 'FormasPagtoTable';
    public $tabela = 'formas_pagto';
    public $display = 'nome';
    public $filterArgs = [
        'nome' => 'like',
    ];

    public function __construct()
    {
        parent::__construct();
    }

}
