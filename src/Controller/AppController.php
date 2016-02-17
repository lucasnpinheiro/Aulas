<?php

namespace App\Controller;

use Core\Controller;

class AppController extends Controller {

    public function __construct(\Core\Request $request, \Core\Session $session, \Core\Auth $auth) {
        parent::__construct($request, $session, $auth);
        $this->helper = [
            ['nome' => 'Html', 'class' => 'BootstrapHtmlHelper'],
            ['nome' => 'Form', 'class' => 'BootstrapFormHelper'],
            ['nome' => 'Table', 'class' => 'TableHelper']
        ];
    }

}
