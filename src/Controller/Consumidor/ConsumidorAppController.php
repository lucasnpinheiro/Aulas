<?php

namespace App\Controller\Consumidor;

use App\Controller\AppController;

class ConsumidorAppController extends AppController
{

    public $totalregistro = 10;

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->Auth->setConfig('clientes');
        $this->layout = 'consumidor';
        $this->set('titulo', 'Título não Informado');
        
        if (!$this->Auth->check()){
            $this->redirect('/home/logout');
        }
    }

}
