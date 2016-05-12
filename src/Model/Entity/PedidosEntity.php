<?php

namespace App\Model\Entity;

use Core\Database\Entity;

/**
 * Description of PedidosEntity
 *
 * @author Admin
 */
class PedidosEntity extends Entity {

    public $status_descricao = null;

    public function relacoes() {
        $this->hasOne('Clientes', ['className' => 'Clientes', 'foreignKey' => 'cliente_id']);
        $this->hasOne('FormaPagto', ['className' => 'FormasPagto', 'foreignKey' => 'forma_pagto_id']);
        $this->belongsTo('PedidosItens', ['className' => 'PedidosItens', 'foreignKey' => 'pedido_id']);
    }

    public function _getStatus() {
        if (isset($this->status)) {
            switch ($this->status) {
                case 0:
                    $this->status_descricao = 'Inativo';

                    break;
                case 1:
                    $this->status_descricao = 'Ativo';

                    break;
                case 9:
                    $this->status_descricao = 'Excluido';

                    break;

                default:
                    $this->status_descricao = 'Não Informado';

                    break;
            }
        }
    }

}
