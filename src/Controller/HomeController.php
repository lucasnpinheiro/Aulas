<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author lucas
 */

namespace src\Controller;

use src\Controller\AppController;

class HomeController extends AppController {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $db = new \src\Model\Table\ClientesTable();
        $f = $db->all();
        debug($f);
        $this->set('teste', 'Este é o meu teste.');
    }

    public function _remap() {
        echo '_remap';
    }

}
