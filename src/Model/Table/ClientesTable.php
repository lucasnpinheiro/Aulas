<?php

/**
 * Description of UsuariosTable
 *
 * @author lucas
 */
// carrega a clase de conexão com o banco de dados

namespace src\Model\Table;

use Core\Database\Table;

// criando a classe e usando referencia da classe extendida
class ClientesTable extends Table {

    // itentificação da classe de objetos que vai ser usada
    public $classe = 'ClientesEntity';
    public $tabela = 'clientes';

    public function __construct() {
        parent::__construct();
        
        $this->validacao = array(
            'nome'=> 'required',
            'data_nascimento'=> 'data',
        );
    }

}
