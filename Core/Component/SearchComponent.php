<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Component;

/**
 * Description of SearchComponents
 *
 * @author lucas
 */
use Core\Component\ConfigComponent;

class SearchComponent extends ConfigComponent {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function prepare() {
        if ($this->request->isMethod('post')) {
            $this->redirect(['?' => $this->request->data]);
        }
    }

}
