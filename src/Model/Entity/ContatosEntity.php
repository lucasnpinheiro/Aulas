<?php

namespace App\Model\Entity;

use Core\Database\Entity;

class ContatosEntity extends Entity {

    public function getNome() {
        return $this->nome[0];
    }

}
