<?php

namespace App\Model\Table;

use Core\Database\Table;

class ClientesTable extends Table
{

    public $classe = 'ClientesEntity';
    public $tabela = 'clientes';

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
        $this->data['cpf'] = str_replace(['.', '-'], '', $this->data['cpf']);
        $this->data['email'] = strtolower($this->data['email']);
    }

}
