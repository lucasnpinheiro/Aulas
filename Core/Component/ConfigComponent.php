<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Components
 *
 * @author lucas
 */

namespace Core\Component;

use Core\Controller;

class ConfigComponent extends Controller {

    //put your code here

    public $default = array();

    public function __construct(array $config = array()) {
        parent::__construct();
        $this->init($config);
    }

    public function init(array $config = array()) {
        $this->default = array_merge($this->default, $config);
    }

}
