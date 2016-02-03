<?php

namespace Core\Traits;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FuncoesTrait
 *
 * @author lucas
 */
trait FuncoesTrait {

    /**
     * 
     * Remove todos os caracteres diferente de 0123456789
     * 
     * @param String $str
     * @return Integer
     */
    public function soNumero($str) {
        return (int) preg_replace("/[^0-9]/", "", $str);
    }

    /**
     * 
     * função que converte a data passada
     * 
     * @param string $data
     * @param string $separador
     * @param string $include
     * @return string
     */
    public function convertData($data, $separador = '/', $include = '-') {
        $ex = explode(' ', $data);
        $ex[0] = implode($include, array_reverse(explode($separador, $ex[0])));
        return implode(' ', $ex);
    }

    /**
     * 
     * função que converte a data passada
     * 
     * @param string $data
     * @param string $separador
     * @param string $include
     * @return string
     */
    public function money($str) {
        if (stripos($str, ',') !== false) {
            $str = str_replace('R$', '', $str);
            $str = str_replace('.', '', $str);
            return (float) str_replace(',', '.', $str);
        } else {
            return (string) 'R$ ' . number_format($str, 2, ',', '.');
        }
    }

    public function mes($mes) {
        $m = [
            '1' => 'Janeiro',
            '2' => 'Fevereiro',
            '3' => 'Março',
            '4' => 'Abril',
            '5' => 'Maio',
            '6' => 'Junho',
            '7' => 'Julho',
            '8' => 'Agosto',
            '9' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembo',
        ];
        return (!empty($m[(int) $mes]) ? $m[(int) $mes] : null);
    }

}
