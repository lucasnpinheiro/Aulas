<?php

namespace App\Controller;

use Core\Controller;

class AppController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->helper = [
            ['nome' => 'Html', 'class' => 'HtmlHelper'],
            ['nome' => 'Form', 'class' => 'BootstrapFormHelper'],
            ['nome' => 'Table', 'class' => 'TableHelper']
        ];
    }

}
