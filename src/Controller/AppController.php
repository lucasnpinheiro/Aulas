<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace src\Controller;

use Core\Controller;

/**
 * Description of AppController
 *
 * @author lucas
 */
class AppController extends Controller {

    
    
    public function __construct() {
        parent::__construct();
        $this->helper = [
            ['nome' => 'Html', 'class' => 'HtmlHelper'],
            ['nome' => 'Form', 'class' => 'FormHelper']
        ];
    }

}
