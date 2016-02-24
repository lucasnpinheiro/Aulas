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
        if (!empty($data)) {
           if (stripos($data, $separador) !== false) {
                $ex = explode(' ', $data);
                $ex[0] = implode($include, array_reverse(explode($separador, $ex[0])));
                return implode(' ', $ex);
            }
        }
        return null;
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
    public function money($str, $options = []) {
        if (trim($str) != '') {
            if (stripos($str, ',') !== false) {
                $str = str_replace('R$', '', $str);
                $str = str_replace('.', '', $str);
                return (float) str_replace(',', '.', $str);
            } else {
                $defautl = [
                    'prefix' => 'R$ '
                ];
                $options = \Core\Hash::merge($defautl, $options);
                return (string) $options['prefix'] . number_format($str, 2, ',', '.');
            }
        }
        return null;
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

    public function forceMoney($str, $divisor = '.') {
        $real = substr($str, 0, strlen($str) - 2);
        $centavos = substr($str, strlen($str) - 2, 2);
        return ($real . $divisor . $centavos);
    }

    public function forceBollean($str) {
        if (is_string($str)) {
            if ($str === 'true') {
                return true;
            } else if ($str === 'false') {
                return false;
            }
        }
        return $str;
    }

    public function truncate($str, $limit = 15) {
        $str = trim($str);
        if (strlen($str) > $limit) {
            return substr($str, 0, $limit) . '...';
        }
        return $str;
    }

    public function primeiroNome($str) {
        $str = trim($str);
        if (!empty($str)) {
            $ex = explode(' ', $str);
            return $ex[0];
        }
        return $str;
    }

}
