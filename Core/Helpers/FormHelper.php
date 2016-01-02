<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Helpers;

use Core\Helpers\Helper;
use Core\Helpers\HtmlHelper;

/**
 * Description of FormHelper
 *
 * @author lucas
 */
class FormHelper extends Helper {

//put your code here


    public $id = null;
    public $html = null;
    public $error = [];
    public $types = array(
        'color',
        'date',
        'datetime',
        'datetime-local',
        'email',
        'month',
        'number',
        'range',
        'search',
        'tel',
        'time',
        'url',
        'week',
        'text',
        'textarea',
        'select',
        'radio',
        'checkbox',
        'hidden',
    );

    public function __construct() {
        parent::__construct();
        $this->html = new HtmlHelper();
    }

    public function create($url = '', $options = array()) {
        if (!is_null($url) and trim($url) === '') {
            $url = $this->request->controller . '/' . $this->request->action;
        }

        $default = array(
            'class' => '',
            'name' => $this->getName($this->request->controller . ' ' . $this->request->action, 'From'),
            'id' => $this->getId($this->request->controller . ' ' . $this->request->action, 'From'),
            'method' => 'post',
            'accept-charset' => 'UTF-8',
            'autocomplete' => 'on',
            'enctype' => 'multipart/form-data',
            'action' => $this->request->url($url),
        );

        $options = array_merge($default, $options);

        $this->id = $options['id'];

        if (isset($options['type'])) {
            if ($options['type'] == 'file') {
                $options['method'] = 'post';
                $options['enctype'] = 'multipart/form-data';
            }
            unset($options['type']);
        }
        return $this->html->tags('form', $options, false);
    }

    public function input($field, $options = array()) {
        $default = array(
            'type' => 'text',
            'name' => $this->getName($field),
            'id' => $this->getId($field),
            'required' => false,
            'value' => '',
            'label' => '',
            'div' => array(),
        );

        $options = array_merge($default, $options);

        if (!in_array($options['type'], $this->types)) {
            $options['type'] = 'text';
        }
        $label = '';
        if ($options['label'] !== false) {
            $label = $this->label($options['label'], array('for' => $options['id']));
        }
        unset($options['label']);
        $div = array(
            'class' => $options['type'] . ' ' . ($options['required'] ? 'required' : '')
        );
        if (!empty($options['div'])) {
            if (isset($options['div']['class'])) {
                $options['div']['class'] .= ' ' . $div['class'];
            }
            $div = array_merge($div, $options['div']);
        }
        unset($options['div']);

        return $this->html->tags('div', $div, true, $label . $this->{\Core\Inflector::parameterize($options['type'], '_')}($options));
    }

    private function text($option) {
        return $this->html->tags('input', $option, false);
    }

    private function hidden($option) {
        return $this->html->tags('input', $option, false);
    }

    private function date($option) {
        return $this->html->tags('input', $option, false);
    }

    private function datetime($option) {
        return $this->html->tags('input', $option, false);
    }

    private function color($option) {
        return $this->html->tags('input', $option, false);
    }

    private function datetime_local($option) {
        return $this->html->tags('input', $option, false);
    }

    private function email($option) {
        return $this->html->tags('input', $option, false);
    }

    private function month($option) {
        return $this->html->tags('input', $option, false);
    }

    private function number($option) {
        return $this->html->tags('input', $option, false);
    }

    private function range($option) {
        return $this->html->tags('input', $option, false);
    }

    private function search($option) {
        return $this->html->tags('input', $option, false);
    }

    private function tel($option) {
        return $this->html->tags('input', $option, false);
    }

    private function time($option) {
        return $this->html->tags('input', $option, false);
    }

    private function url($option) {
        return $this->html->tags('input', $option, false);
    }

    private function week($option) {
        return $this->html->tags('input', $option, false);
    }

    private function radio($option) {
        return $this->html->tags('input', $option, true);
    }

    private function checkbox($option) {
        return $this->html->tags('input', $option, true, $options);
    }

    private function select($option) {
        $default = array(
            'multiple' => false,
            'name' => '',
            'size' => '',
            'options' => '',
            'class' => '',
            'id' => '',
        );
        $option = array_merge($default, $option);
        $options = '';
        if (!empty($option['options'])) {
            foreach ($option['options'] as $key => $value) {
                if (!is_array($value)) {
                    $options .= '<option value="' . $key . '">' . $value . '</option>';
                } else {
                    $options .= '<optgroup label="' . $key . '">';
                    foreach ($value as $k => $v) {
                        $options = '<option value="' . $k . '">' . $v . '</option>';
                    }
                    $options .= '</optgroup>';
                }
            }
        }
        unset($option['options']);
        return $this->html->tags('select', $option, true);
    }

    private function textarea($option) {
        $label = $option['value'];
        unset($option['value']);
        unset($option['type']);
        return $this->html->tags('textarea', $option, true, $label);
    }

    public function label($label, $options = array()) {
        $default = array(
            'id' => $this->getId($label, 'Label'),
            'class' => '',
            'for' => $this->getId($label),
        );
        $options = array_merge($default, $options);
        return $this->html->tags('label', $options, true, $label);
    }

    public function button($name, $options = array()) {
        $default = array(
            'form' => $this->id,
            'id' => $this->getId($name, 'Button'),
            'name' => $this->getName($name, 'Button'),
            'type' => 'submit',
            'class' => '',
        );
        $options = array_merge($default, $options);
        return $this->html->tags('button', $options, true, $name);
    }
    
    public function error($dados){
        $this->error = $dados;
    }

    public function end() {
        return '</form>';
    }

}
