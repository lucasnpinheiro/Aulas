<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Helpers;

use Core\Helpers\FormHelper;
use Core\Helpers\HtmlHelper;
use Core\Inflector;

/**
 * Description of BootstrapHtmlHelper
 *
 * @author lucas
 */
class BootstrapHtmlHelper extends HtmlHelper {

    use \Core\Traits\FuncoesTrait;

    public function sexo($id) {
        $s = ['M' => 'Masculino', 'F' => 'Feminino'];
        return $s[$id];
    }

    public function genero($id) {
        $s = ['M' => 'Macho', 'F' => 'Femia'];
        return $s[$id];
    }

    public function data($data) {
        $data = $this->convertData($data, '-', '/');
        $data = explode(' ', $data);
        return $data[0];
    }

    public function dataHora($data) {
        return $this->convertData($data, '-', '/');
    }

    public function primeiroNome($string) {
        $exp = explode(' ', trim($string));
        return $exp[0];
    }

}
