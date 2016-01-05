<?php

namespace Core\Helpers;

use Core\Helpers\Helper;
use Core\Helpers\HtmlHelper;

/**
 * Classe para geração de formularios.
 *
 * @author Lucas Pinheiro
 */
class FormHelper extends Helper {

    /**
     *
     * Identificação do Formulario
     * 
     * @var string 
     */
    public $id = null;

    /**
     *
     * Carrega a classe HtmlHelper
     * 
     * @var string 
     */
    public $html = null;

    /**
     *
     * Erros gerados pelo controller para setar no Formulario
     * 
     * @var array 
     */
    public $error = [];

    /**
     *
     * Tipos de inputs que são permitidos no HTML5
     * 
     * @var array 
     */
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

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct() {
        parent::__construct();
        $this->html = new HtmlHelper();
    }

    /**
     * 
     * Inicia a criação do formulario
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
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

    /**
     * 
     * Cria um input
     * 
     * @param string $field
     * @param array $options
     * @return string
     */
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

    /**
     * 
     * Input do tipo text
     * 
     * @param array $option
     * @return string
     */
    private function text($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo hidden
     * 
     * @param array $option
     * @return string
     */
    private function hidden($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo date
     * 
     * @param array $option
     * @return string
     */
    private function date($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo datetime
     * 
     * @param array $option
     * @return string
     */
    private function datetime($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo color
     * 
     * @param array $option
     * @return string
     */
    private function color($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo detetime_local
     * 
     * @param array $option
     * @return string
     */
    private function datetime_local($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo email
     * 
     * @param array $option
     * @return string
     */
    private function email($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo month
     * 
     * @param array $option
     * @return string
     */
    private function month($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo number
     * 
     * @param array $option
     * @return string
     */
    private function number($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo range
     * 
     * @param array $option
     * @return string
     */
    private function range($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo search
     * 
     * @param array $option
     * @return string
     */
    private function search($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo tel
     * 
     * @param array $option
     * @return string
     */
    private function tel($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo time
     * 
     * @param array $option
     * @return string
     */
    private function time($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo url
     * 
     * @param array $option
     * @return string
     */
    private function url($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo week
     * 
     * @param array $option
     * @return string
     */
    private function week($option) {
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo radio
     * 
     * @param array $option
     * @return string
     */
    private function radio($option) {
        return $this->html->tags('input', $option, true);
    }

    /**
     * 
     * Input do tipo checkbox
     * 
     * @param array $option
     * @return string
     */
    private function checkbox($option) {
        return $this->html->tags('input', $option, true, $options);
    }

    /**
     * 
     * Input do tipo select
     * 
     * @param array $option
     * @return string
     */
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

    /**
     * 
     * Input do tipo textarea
     * 
     * @param array $option
     * @return string
     */
    private function textarea($option) {
        $label = $option['value'];
        unset($option['value']);
        unset($option['type']);
        return $this->html->tags('textarea', $option, true, $label);
    }

    /**
     * 
     * Cria um label
     * 
     * @param string $label
     * @param array $options
     * @return string
     */
    public function label($label, $options = array()) {
        $default = array(
            'id' => $this->getId($label, 'Label'),
            'class' => '',
            'for' => $this->getId($label),
        );
        $options = array_merge($default, $options);
        return $this->html->tags('label', $options, true, $label);
    }

    /**
     * 
     * Cria um botão
     * 
     * @param string $name
     * @param array $options
     * @return string
     */
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

    /**
     * 
     * Captura os erros gerados ao submeter o formulario
     * 
     * @param array $dados
     */
    public function error($dados) {
        $this->error = $dados;
    }

    /**
     * 
     * Finaliza o Formulario
     * 
     * @return string
     */
    public function end() {
        return '</form>';
    }

}
