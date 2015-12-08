<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of App
 *
 * @author lucas
 */
class App {

    public function __construct() {
        
    }

    public function toUpper($str) {
        $str = explode('_', $str);
        foreach ($str as $key => $value) {
            $str[$key] = ucfirst(strtolower($value));
        }
        return implode('', $str);
    }

    public function toLower($str) {
        $str = explode('_', $str);
        foreach ($str as $key => $value) {
            $str[$key] = strtolower($value);
            if ($key > 0) {
                $str[$key] = ucfirst(strtolower($value));
            }
        }
        return implode('', $str);
    }

}
