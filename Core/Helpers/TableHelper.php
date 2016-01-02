<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Helpers;

use Core\Helpers\Helper;
use Core\Helpers\HtmlHelper;

/**
 * Description of TableHelper
 *
 * @author lucas
 */
class TableHelper extends Helper {

    //put your code here
    public $html = null;

    public function __construct() {
        parent::__construct();
        $this->html = new HtmlHelper();
    }

    public function create($options = array()) {
        return $this->html->tags('table', $options, false);
    }

    public function tr($td, $options = array()) {
        return $this->html->tags('tr', $options, true, $td);
    }

    public function th($value, $options = array()) {
        return $this->html->tags('th', $options, true, $this->convertArrayInString($value));
    }

    public function td($value, $options = array()) {
        return $this->html->tags('td', $options, true, $this->convertArrayInString($value));
    }

    public function tbody($tr, $options = array()) {
        return $this->html->tags('tbody', $options, true, $this->convertArrayInString($tr));
    }

    public function thead($tr, $options = array()) {
        return $this->html->tags('thead', $options, true, $this->convertArrayInString($tr));
    }

    public function tfoot($tr, $options = array()) {
        return $this->html->tags('tfoot', $options, true, $this->convertArrayInString($tr));
    }

    public function caption($caption, $options = array()) {
        return $this->html->tags('caption', $options, true, $this->convertArrayInString($caption));
    }

    public function end() {
        return '</table>';
    }

    private function convertArrayInString($dados) {
        if (is_array($dados)) {
            return implode(' ', $dados);
        }
        return $dados;
    }

}
