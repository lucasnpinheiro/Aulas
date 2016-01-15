<?php

namespace App\Controller\Painel;

use App\Controller\Painel\PainelAppController;

class UsuariosController extends PainelAppController {

    //put your code here
    public function index() {
        echo'Meu Painel';
        $this->loadTable('Clientes');
        $f = $this->Clientes->schema()->tables();
        $f = $this->Clientes->dump()->up('aulas_2016_01_15_11_21_32.sql');
        debug($f);
    }

}
