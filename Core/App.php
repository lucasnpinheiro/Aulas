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
    public static function search($key, $dados) {
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
    public static function setSearch($niveis, $value, $temp = array(), $seq = 0) {
        if (isset($niveis[$seq])) {
            $temp = array($niveis[$seq]=> $value);
            //array_push($temp, $aux);
            return self::setSearch($niveis, $value, $temp, ++$seq);
        } else {
            return $temp;
        }
    }

}
