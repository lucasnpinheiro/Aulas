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

    public function input($field, $options = array()) {
        if (!isset($options['class'])) {
            $options['class'] = '';
        }
        $options['class'] .= ' form-control';

        $group = array();
        $div = array();
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

}
