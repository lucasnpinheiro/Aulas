<?php

namespace App\Controller\Painel;

use App\Controller\AppController;

class PainelAppController extends AppController {

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);
    }

}
