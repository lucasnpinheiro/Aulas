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
class ClientesTable extends Database {

    // itentificação da classe de objetos que vai ser usada
    public $classe = 'ClientesEntity';
    public $tabela = 'clientes';

    public function __construct() {
        parent::__construct();
    }

}
