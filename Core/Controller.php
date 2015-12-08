<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Controller
 *
 * @author lucas
 */
class Controller {

    //put your code here
    public $request = null;

    public function __construct() {
        $this->request = new Request();
    }

    public function beforeFilter() {
        
    }

    public function afterFilter() {
        
    }

}
