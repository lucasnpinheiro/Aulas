<?php

/*
 * Configurações de rotas de acesso ao controllers do sistema.
 */
$config = [
    'default' => [
        'model' => 'Usuarios',
        'crypt' => 'md5',
        'params' => [
            'email' => 'email',
            'password' => 'senha'
        ],
        'redirect' => [
            'success' => '/painel/empresas_usuarios/index',
            'error' => '/'
        ]
    ]
];
