<?php

/*
 * Configurações de rotas de acesso ao controllers do sistema.
 */
$config = array(
    '/' => 'Home.login',
    '/painel' => 'Painel.Clientes.index',
    '/esqueci_senha' => 'Home.esqueci_senha',
    '/cadastrar' => 'Home.add',
    '/sair' => 'Home.logout',
);