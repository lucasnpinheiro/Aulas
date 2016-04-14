<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Entity;

use Core\Database\Entity;

/**
 * Description of ProdutosEntity
 *
 * @author Admin
 */
class ProdutosEntity extends Entity
{

    public function _getFoto()
    {
        if (empty($this->foto))
        {
            $this->url = '/fotos/semfoto.jpg';
        } else
        {
            if (!file_exists(ROOT . 'webroot' . DS . 'fotos' . DS . $this->foto))
            {
                $this->url = '/fotos/semfoto.jpg';
            } else
            {
                $this->url = '/fotos/' . $this->foto;
            }
        }
    }

}
