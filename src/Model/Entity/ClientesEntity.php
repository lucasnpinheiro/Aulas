<?php

/**
 * Description of UsuariosEntity
 *
 * @author lucas
 */

namespace src\Model\Entity;

use Core\Entity;

class ClientesEntity extends Entity {
    
    public function getNome(){
        return $this->nome[0];
    }
    
}
