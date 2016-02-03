<?php

namespace Core\Helpers;

use Core\Helpers\FormHelper;
use Core\Helpers\HtmlHelper;
use Core\Inflector;

/**
 * Classe para geração de formularios.
 *
 * @author Lucas Pinheiro
 */
class BootstrapFormHelper extends FormHelper {

   

    public function __construct() {
        parent::__construct();
        $this->html = new HtmlHelper();
    }

    public function input($field, $options = []) {
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' form-control';

        $group = [];
        $div = [];
        if (isset($options['div'])) {
            $div = $options['div'];
            unset($options['div']);
        }

        if (isset($options['before'])) {
            $group['after'] = $options['before'];
            unset($options['before']);
        }

        if (isset($options['after'])) {
            $group['after'] = $options['after'];
            unset($options['after']);
        }
        if (isset($options['group'])) {
            $group = array_merge($group, $options['group']);
            unset($options['group']);
        }

        if (!isset($div['class'])) {
            $div['class'] = '';
        }
        $div['class'] .= ' form-group';
        $input = parent::input($field, $options);
        if ($options['type'] == 'hidden') {
            return $input;
        }
        if (!empty($group)) {
            $input = preg_replace("/<div[^>]+>(.+?)<\/div>/ims", "$1", $input);
            $grupoOptions = $group;
            unset($grupoOptions['before'], $grupoOptions['after']);
            if (empty($grupoOptions['class'])) {
                $grupoOptions['class'] = '';
            }
            $grupoOptions['class'] .= ' input-group';
            $g = '';
            if (isset($group['before'])) {
                $g .= $group['before'];
            }
            $g .= $input;
            if (isset($group['after'])) {
                $g .= $group['after'];
            }
            $input = $this->html->tags('div', $grupoOptions, true, $g);
            unset($g);
        }
        $input = $this->html->tags('div', $div, true, $input);
        return $input;
    }

    public function moeda($field, $options = []) {
        $options['type'] = 'text';
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        if (!empty($this->request->data($field)) AND empty($options['value'])) {
            $options['value'] = $this->money($this->request->data($field));
        }
        $options['class'] .= ' moeda';
        return $this->input($field, $options);
    }

    public function data($field, $options = []) {
        $options['type'] = 'text';
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' data datepicker form-control';
        $options['data-date-format'] = 'dd/mm/yyyy';
        $options['data-provide'] = 'datepicker';
        if (!empty($this->request->data($field)) AND empty($options['value'])) {
            $options['value'] = $this->convertData($this->request->data($field), '-', '/');
        }

        return $this->input($field, $options);
    }

    public function dataHora($field, $options = []) {
        $options['type'] = 'text';
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' data_hora';
        //$options['data-date-format'] = 'dd/mm/yyyy hh:ii:ss';
        //$options['data-provide'] = 'datepicker';

        if (!empty($this->request->data($field)) AND empty($options['value'])) {
            $options['value'] = $this->convertData($this->request->data($field), '-', '/');
        }
        return $this->input($field, $options);
    }

    public function hora($field, $options = []) {
        $options['type'] = 'text';
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' hora';
        if (!empty($this->request->data($field)) AND empty($options['value'])) {
            $options['value'] = $this->request->data($field);
        }

        return $this->input($field, $options);
    }

    public function telefone($field, $options = []) {
        $options['type'] = 'text';
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' telefone';
        
        return $this->input($field, $options);
    }

}
