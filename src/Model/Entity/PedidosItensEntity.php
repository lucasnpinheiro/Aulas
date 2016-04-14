<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Entity;

use Core\Database\Entity;

/**
 * Description of PedidosItensEntity
 *
 * @author Admin
 */
class PedidosItensEntity extends Entity
{
    //put your code here
    public function relacoes(){
        $this->hasOne('Produtos',['className'=>'Produtos','foreignKey'=>'produto_id']);
    }
}
