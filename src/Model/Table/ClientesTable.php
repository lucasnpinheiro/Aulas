<?php

namespace src\Model\Table;

use Core\Database\Table;

class ClientesTable extends Table {

    public $classe = 'ClientesEntity';
    public $tabela = 'clientes';

    public function __construct() {
        parent::__construct();

        $this->validacao = array(
            'nome' => array(
                'required' => 'required',
                'extensao' => '.txt',
                'min' => 3,
                'max' => 10
            ),
            'data_nascimento' => array(
                'data',
                'unique'
            ),
        );
    }

    public function beforeSave() {
        if (isset($this->data['data_nascimento'])) {
            $this->data['data_nascimento'] = $this->_convertData($this->data['data_nascimento']);
        }
    }

}
