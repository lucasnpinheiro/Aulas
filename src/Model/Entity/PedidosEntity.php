<?php

namespace App\Model\Entity;

use Core\Database\Entity;

/**
 * Description of PedidosEntity
 *
 * @author Admin
 */
class PedidosEntity extends Entity
{

    public function relacoes()
    {
        $this->hasOne('Clientes', ['className' => 'Clientes', 'foreignKey' => 'cliente_id']);
        $this->hasOne('FormaPagto', ['className' => 'FormasPagto', 'foreignKey' => 'forma_pagto_id']);
        $this->belongsTo('PedidosItens', ['className' => 'PedidosItens', 'foreignKey' => 'pedido_id']);
    }

}
