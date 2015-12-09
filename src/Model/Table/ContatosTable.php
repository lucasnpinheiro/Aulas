<?php

/**
 * Description of UsuariosTable
 *
 * @author lucas
 */
// carrega a clase de conexão com o banco de dados

namespace src\Model\Table;

use Core\Database;

// criando a classe e usando referencia da classe extendida
class ContatosTable extends Database {

    // itentificação da classe de objetos que vai ser usada
    public $classe = 'ContatosEntity';
    public $tabela = 'contatos';

    public function __construct() {
        parent::__construct();
    }

}
