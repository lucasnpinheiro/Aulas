<?php

namespace App\Model\Table;

use Core\Database\Table;

class UsuariosTable extends Table {

    public $classe = 'UsuariosEntity';
    public $tabela = 'usuarios';

    public function __construct() {
        parent::__construct();

    }
}
