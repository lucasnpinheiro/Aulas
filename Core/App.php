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

    /**
     * 
     * Função que faz a busca dos dados para localizar o referencia da nevegação.
     * 
     * @param string Chave de navegação
     * @param string Resutado default caso não for achado nenhum resultado referente a navegação
     * @return array|string|null
     */
    public static function findArray($key, $dados) {
        $s = explode('.', $key);
        $t = count($s) - 1;
        foreach ($s as $k => $v) {
            if (isset($dados[$v])) {
                if ($k === $t) {
                    return $dados[$v];
                }
                $dados = $dados[$v];
            }
        }
        return null;
    }

    /**
     * 
     * Função que faz a busca dos dados para localizar o referencia da nevegação.
     * 
     * @param string Chave de navegação
     * @param string Resutado default caso não for achado nenhum resultado referente a navegação
     * @return array|string|null
     */
    public static function setFindArray($path, $value = null) {
        $separator = '.';
        $pos = strpos($path, $separator);
        if ($pos === false) {
            return array($path => $value);
        }
        $key = substr($path, 0, $pos);
        $path = substr($path, $pos + 1);
        $result = array($key => self::setFindArray($path, $value));
        return $result;
    }

    public static function arrayImplode($array, $string = null) {
        if (empty($string)) {
            $string = implode('.', array_keys($array));
        }
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                return trim(self::arrayImplode($value, $string . '.' . implode('.', array_keys($value))), '.');
            }
        }
        return trim($string, '.');
    }

}
