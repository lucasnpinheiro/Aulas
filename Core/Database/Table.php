<?php

namespace Core\Database;

use Core\Database\Database;

/**
 * Classe que realiza o ponte da classe databese para uma classe pré para tratamentos de algumas informações genericas no banco de dados.
 *
 * @author Lucas Pinheiro
 */
class Table extends Database {

    public function __construct() {
        parent::__construct();
    }

}
