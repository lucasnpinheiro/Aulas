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

class ConfigComponent extends Controller
{

    //put your code here

    public $default = [];

    public function __construct(array $config = [])
    {
        parent::__construct(new \Core\Request(), new \Core\Session(), new \Core\Auth());
        $this->init($config);
    }

    public function init(array $config = [])
    {
        $this->default = \Core\Hash::merge($this->default, $config);
    }
}
