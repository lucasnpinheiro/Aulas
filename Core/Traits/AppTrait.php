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
trait AppTrait {

    /**
     * 
     * Função que faz a busca dos dados para localizar o referencia da nevegação.
     * 
     * @param string $key Chave de navegação
     * @param string $dados
     * @return array|string|null
     */
    /* public static function findArray($key, $dados)
      {
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
      } */
    public static function findArray($key, $dados) {
        $p = $r = $o = null;
        $key = trim($key, '.');
        if (empty($key)) {
            return $dados;
        }

        $key = explode('.', $key);
        $o = $dados;

        while (count($key) > 0) {
            $p = array_shift($key);

            if (!isset($o[$p])) {
                return null;
            }
            $r = $o[$p];
            $o = (is_array($r) ? $r : []);
        }

        return $r;
    }

    /**
     * 
     * Função que faz a busca dos dados para localizar o referencia da nevegação.
     * 
     * @param string $path Chave de navegação
     * @param string $value
     * @return array|string|null
     */
    public static function setFindArray($path, $value = null) {
        $separator = '.';
        $pos = strpos($path, $separator);
        if ($pos === false) {
            return [$path => $value];
        }
        $key = substr($path, 0, $pos);
        $path = substr($path, $pos + 1);
        $result = [$key => self::setFindArray($path, $value)];
        return $result;
    }

    /**
     * 
     * Função que converte uma string em array multidimensional
     * 
     * @param array $array
     * @param string $string
     * @return string
     */
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

    public function merge($a, $b, $r = []) {
        if (!empty($a)) {
            foreach ($a as $key => $value) {
                $r[$key] = $value;
            }
        }
        if (!empty($b)) {
            foreach ($b as $key => $value) {
                $r[$key] = $value;
            }
        }
        return $r;
    }

}
