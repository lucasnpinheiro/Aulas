<?php

namespace Core;

/**
 * Classe base da Aplicação
 *
 * @author Lucas Pinheiro
 */
class App {

    public function __construct() {
        
    }

    /**
     * 
     * @param string Entrada de uma string para ser formatada
     * @return string retorna a string formatada
     */
    public function toUpper($str) {
        $str = explode('_', $str);
        foreach ($str as $key => $value) {
            $str[$key] = ucfirst(strtolower($value));
        }
        return implode('', $str);
    }

    /**
     * 
     * @param string Entrada de uma string para ser formatada
     * @return string retorna a string formatada
     */
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
