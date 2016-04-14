<?php

namespace App\Model\Table;

use Core\Database\Table;

class ProdutosTable extends Table
{

    public $classe = 'ProdutosEntity';
    public $tabela = 'produtos';
    public $filterArgs = [
        'nome' => 'like',
        'codigo' => 'like',
        'pesquisar' => [
            'campos' => ['nome', 'descricao_produto'],
            'tipo' => 'like'
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function upload($foto)
    {
        if (!empty($foto['name'])and $foto['error'] === 0)
        {
            $file = new \Core\Files($foto['name']);
            $nome = md5($foto['name'] . time()) . '.' . $file->extension();
            if (copy($foto['tmp_name'], ROOT . 'webroot' . DS . 'fotos' . DS . $nome))
            {
                return $nome;
            }
        }

        return false;
    }

    public function removeFoto($id)
    {
        $find = $this->findById($id);
        $foto = $find->foto;
        if (!empty($foto) and file_exists(ROOT . 'webroot' . DS . 'fotos' . DS . $foto))
        {
            unlink(ROOT . 'webroot' . DS . 'fotos' . DS . $foto);
        }
        return true;
    }

}
