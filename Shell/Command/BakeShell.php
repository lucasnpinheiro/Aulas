<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BakeShell
 *
 * @author lucas
 */

namespace Shell\Command;

use Shell\Command\AppShell;

class BakeShell extends AppShell
{

    //put your code here
    public function __construct($argv = [])
    {
        parent::__construct($argv);
    }

    public function init()
    {
        $class = new \stdClass();
        $class->teste = 'aaa';
        $class->value = 12;
        $this->color($class, 'red');
        debug($class);
        $this->color($this->params, 'green');
        debug($this->params);
        $this->loadModel('Clientes');
        $this->color($this->Clientes->all(), 'Cyan');
    }
}
