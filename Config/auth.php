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
            'success' => '/painel/usuarios/index',
            'error' => '/'
        ]
    ],
    'clientes' => [
        'model' => 'Clientes',
        'crypt' => 'md5',
        'keyName' => 'Auth.Clientes',
        'params' => [
            'email' => 'email',
            'password' => 'senha'
        ],
        'redirect' => [
            'success' => '/clientes/home/index',
            'error' => '/clientes/home/index'
        ]
    ]
];
