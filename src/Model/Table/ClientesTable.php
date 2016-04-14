<?php

namespace App\Model\Table;

use Core\Database\Table;

class ClientesTable extends Table
{

    public $classe = 'ClientesEntity';
    public $tabela = 'clientes';

    public $filterArgs=[
        'nome'=>'like',
        'cpf'=>'like' ,
        'email'=>'like'
    ];
    
    public function __construct()
    {
        parent::__construct();

        $this->validacao = [
            'nome' => [
                'required', 'min' => 3, 'max' => 255
            ],
            'cpf' => [
                'required', 'unique', 'numero', 'max' => 18
            ],
            'email' => [
                'required', 'unique'
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
        
        $this->data['cpf'] = str_replace(['.', '-'], '', $this->data['cpf']);
        $this->data['email'] = strtolower($this->data['email']);
    }

}



