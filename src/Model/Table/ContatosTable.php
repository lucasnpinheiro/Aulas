<?php

namespace App\Model\Table;

use Core\Database\Table;

class ContatosTable extends Table {

    public $classe = 'ContatosEntity';
    public $tabela = 'contatos';

    public function __construct() {
        parent::__construct();
    }

}
