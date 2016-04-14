<?php

namespace App\Controller\Painel;

use App\Controller\AppController;

class PainelAppController extends AppController
{

    public $totalregistro = 8;

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth)
    {
        parent::__construct($request, $session, $auth);
        $this->layout = 'painel';
        $this->set('titulo', 'Título não Informado');
        
        if (!$this->Auth->check()){
            $this->redirect('/home/logout');
        }
    }

}
