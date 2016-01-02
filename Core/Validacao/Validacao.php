<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Validacao
 *
 * @author lucas
 */

namespace Core\Validacao;

class Validacao {

    //put your code here

    private $dados = [];
    private $errors = [];
    private $msg = [
        'numero' => 'Somente numeros.',
        'data' => 'Data Invalida.',
        'hora' => 'Hora Invalida.',
        'moeda' => 'Moeda invalida.',
        'email' => 'E-mail invalido.',
        'required' => 'Campo obrigatorio.',
        'min' => 'Quantidade minima de "%s" caracteres.',
        'max' => 'Quantidade maxima de "%s" caracteres.',
        'extensao' => 'Extensão "%s" não é valida.',
        'contem' => 'Valor "%s" não localizado.',
        'unique' => 'Registro com este valor já cadastrado na tabela "%s".',
    ];
    private $campos;

    public function __construct($campo) {
        $this->campos = $campo;
    }

    public function add($campo, $regra, $adicionais = null) {
        $this->dados[$campo][$regra] = $adicionais;
    }

    public function run() {
        foreach ($this->dados as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    if (is_numeric($k)) {
                        $k = $v;
                    }
                    if (!$this->$k($key, $v)) {
                        if (is_object($v)) {
                            $v = $v->tabela;
                        }
                        $this->errors[$key][$k] = sprintf($this->msg[$k], $v);
                    }
                }
            } else {
                if (!$this->$k($key)) {
                    $this->errors[$key] = sprintf($this->msg[$value], $value);
                }
            }
        }
    }

    public function error() {
        return $this->errors;
    }

    public function numero($campo) {
        return (bool) is_numeric($this->campos[$campo]);
    }

    public function moeda($campo) {
        $this->campos[$campo] = str_replace('.', '', $this->campos[$campo]);
        $this->campos[$campo] = str_replace(',', '.', $this->campos[$campo]);
        return (bool) is_float($this->campos[$campo]);
    }

    public function data($campo) {
        $data = explode('/', $this->campos[$campo]);
        $this->campos[$campo] = implode('-', array_reverse($data));
        return (bool) checkdate($data[1], $data[0], $data[2]);
    }

    public function hora($campo) {
        $hora = explode(':', $this->campos[$campo]);
        $count = count($hora);
        switch ($count) {
            case 2: // Hora e minuto
                if (($hora[0] >= 0 and $hora[0] < 24) and ( $hora[1] >= 0 and $hora[1] < 60)) {
                    return true;
                }
                break;
            case 1: // Hora
                if (($hora[0] >= 0 and $hora[0] < 24)) {
                    return true;
                }
                break;

            default: // Hora, minuto e segundo
                if (($hora[0] >= 0 and $hora[0] < 24) and ( $hora[1] >= 0 and $hora[1] < 60) and ( $hora[1] >= 0 and $hora[1] < 60)) {
                    return true;
                }
                break;
        }
        return false;
    }

    public function required($campo) {
        if (isset($this->campos[$campo]) AND trim($this->campos[$campo]) != '') {
            return true;
        }
        return false;
    }

    public function min($campo, $qtd) {
        if (strlen($this->campos[$campo]) >= $qtd) {
            return true;
        }
        return false;
    }

    public function max($campo, $qtd) {
        if (strlen($this->campos[$campo]) <= $qtd) {
            return true;
        }
        return false;
    }

    public function extensao($campo, $extensao) {
        if ((new \SplFileInfo($this->campos[$campo]))->getExtension() === trim($extensao, '.')) {
            return true;
        }
        return false;
    }

    public function email($campo) {
        return (bool) filter_var($this->campos[$campo], FILTER_VALIDATE_EMAIL);
    }

    public function contem($campo, $dados = array()) {
        return (bool) in_array($this->campos[$campo], $dados);
    }

    public function unique($campo, &$classes) {
        $existe = $classes->existeCampo($campo, $this->campos[$campo]);
        if ($existe) {
            return false;
        }
        return true;
    }

}
