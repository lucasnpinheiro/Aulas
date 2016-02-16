<?php

/*
 * Configurações de rotas de acesso ao controllers do sistema.
 */
$config = [
    '/' => 'Home.login',
    '/admin' => 'Home.admin_login',
    '/painel' => 'Painel.BanhosTosas.index',
    '/esqueci_senha' => 'Home.esqueci_senha',
    '/cadastrar' => 'Home.add',
    '/sair' => 'Home.logout',
    '/sair_admin' => 'Home.logout_admin',
];
