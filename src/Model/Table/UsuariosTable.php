<?php

namespace App\Model\Table;

use Core\Database\Table;

class UsuariosTable extends Table
{

    public $classe = 'UsuariosEntity';
    public $tabela = 'usuarios';

    public $filterArgs=[
        'nome'=>'like',
        'username'=>'like'
    ];
    
    public function __construct()
    {
        parent::__construct();

        $this->validacao = [
            'username' => [
                'unique',
                'min' => 10
            ],
            'nome' => [
                'min' => 3
            ]
        ];
    }

    public function beforeSave()
    {
        if (!empty($this->data['senha']))
        {
            $cript = new \Core\Security();
            $this->data['senha'] = $cript->crypt($this->data['senha']);
        } else
        {
            unset($this->data['senha']);
        }
        //$this->data['username'] = $this->removeMask($this->data['username']);
    }

}
