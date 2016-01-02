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
        'numero' => 'Somente numeros',
        'data' => 'Data Invalida',
        'hora' => 'Hora Invalida',
        'moeda' => 'Moeda invalida',
        'required' => 'Campo obrigatorio',
    ];
    private $campos;

    public function __construct(\Core\Request $campo) {
        $this->campos = $campo;
    }

    public function add($campo, $regra, $adicionais = null) {
        $this->dados[$campo][$regra] = $adicionais;
    }

    public function run() {
        foreach ($this->dados as $key => $value) {
            foreach ($value as $k => $v) {
                if (!$this->$k($key, $v)) {
                    $this->errors[$key][$k] = $this->msg[$key];
                }
            }
        }
    }

    public function error() {
        return $this->errors;
    }

    public function numero($campo) {
        return (bool) is_numeric($this->campos->data[$campo]);
    }

    public function moeda($campo) {
        $this->campos->data[$campo] = str_replace('.', '', $this->campos->data[$campo]);
        $this->campos->data[$campo] = str_replace(',', '.', $this->campos->data[$campo]);
        return (bool) is_float($this->campos->data[$campo]);
    }

    public function data($campo) {
        $data = explode('/', $this->campos->data[$campo]);
        $this->campos->data[$campo] = implode('-', array_reverse($data));
        return (bool) checkdate($data[1], $data[0], $data[2]);
    }

    public function hora($campo) {
        $hora = explode(':', $this->campos->data[$campo]);
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
        if (isset($this->campos->data[$campo]) AND trim($this->campos->data[$campo]) != '') {
            return true;
        }
        return false;
    }

}
