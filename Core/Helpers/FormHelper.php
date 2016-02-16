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
     * Identificação do Formulario
     * 
     * @var string 
     */
    public $_label = 'left';

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
    public $types = [
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
        'password',
    ];

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct(\Core\Request $request) {
        parent::__construct($request);
        $this->html = new HtmlHelper($request);
    }

    /**
     * 
     * Inicia a criação do formulario
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
    public function create($url = '', $options = []) {
        if (empty($url)) {
            $url = [
                'controller' => $this->request->controller,
                'action' => $this->request->action,
                'params' => $this->request->params,
            ];
        }
        $default = [
            'class' => '',
            'name' => $this->getName($this->request->controller . '_' . $this->request->action, 'From'),
            'id' => $this->getId($this->request->controller . '_' . $this->request->action, 'From'),
            'method' => 'post',
            'accept-charset' => 'UTF-8',
            'autocomplete' => 'off',
            'enctype' => 'multipart/form-data',
            'action' => $this->request->url($url),
            'label' => 'left',
        ];

        $options = array_merge($default, $options);

        $this->_label = $options['label'];
        unset($options['label']);
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
    public function input($field, $options = []) {
        $default = [
            'type' => 'text',
            'name' => $this->getNameChave($field),
            'id' => $this->getId($field),
            'value' => $this->request->data($field),
            'label' => '',
            'autocomplete' => 'off',
            'div' => [],
        ];

        $options = array_merge($default, $options);

        if (isset($options['required'])) {
            if ((bool) $options['required'] === false) {
                unset($options['required']);
            } else {
                $options['required'] = 'required';
            }
        }

        if (!in_array($options['type'], $this->types)) {
            $options['type'] = 'text';
        }
        $label = '';
        if ($options['label'] !== false) {
            if ($options['type'] != 'checkbox' AND $options['type'] != 'radio') {
                $label = $this->label($options['label'], ['for' => $options['id']]);
            }
        }
        $classField = 'field';
        if ($options['type'] == 'radio' OR $options['type'] == 'checkbox') {
            $classField = '';
        }
        $div = [
            'class' => $options['type'] . ' ' . $classField . ' ' . (isset($options['required']) ? 'required' : '')
        ];
        if (!empty($options['div'])) {
            if (isset($options['div']['class'])) {
                $options['div']['class'] .= ' ' . $div['class'];
            }
            $div = array_merge($div, $options['div']);
        }
        unset($options['div']);
        if ($options['type'] == 'hidden') {
            return $this->{\Core\Inflector::parameterize($options['type'], '_')}($options);
        }

        if ($this->_label == 'left') {
            return $this->html->tags('div', $div, true, $label . $this->{\Core\Inflector::parameterize($options['type'], '_')}($options));
        } else {
            return $this->html->tags('div', $div, true, $this->{\Core\Inflector::parameterize($options['type'], '_')}($options) . $label);
        }
    }

    /**
     * 
     * Input do tipo text
     * 
     * @param array $option
     * @return string
     */
    private function text($option) {
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
        if (!empty($option['value'])) {
            $option['value'] = date('Y-m-d', strtotime($option['value']));
        }
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
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
        unset($option['label']);
        return $this->html->tags('input', $option, false);
    }

    /**
     * 
     * Input do tipo checkbox
     * 
     * @param array $option
     * @return string
     */
    private function checkbox($option) {
        if (!empty($option['class'])) {
            $option['class'] = str_replace('form-control', '', $option['class']);
        }
        if (!empty($option['value'])) {
            $option['checked'] = 'checked';
        }
        $input = $this->html->tags('input', $option, false);
        if (!empty($option['label'])) {
            $input = $this->label($option['label'], ['for' => $option['id']], $input);
        }
        return $input;
    }

    /**
     * 
     * Input do tipo checkbox
     * 
     * @param array $option
     * @return string
     */
    private function radio($option) {
        $r = [];
        foreach ($option['options'] as $key => $value) {
            $dados = $option;
            $dados['value'] = $key;
            unset($dados['options']);
            if (!empty($dados['class'])) {
                $dados['class'] = str_replace('form-control', '', $dados['class']);
            }
            $dados['id'] = $this->getId($dados['id'] . '-' . $value);
            if (!empty($option['value'])) {
                if ($key == $option['value']) {
                    $dados['checked'] = 'checked';
                }
            }
            $input = $this->html->tags('input', $dados, false);
            $input = $this->label($value, ['for' => $dados['id']], $input);
            $r[] = $this->html->tags('div', ['class' => 'radio-item'], true, $input);
        }

        return implode(' ', $r);
    }

    /**
     * 
     * Input do tipo select
     * 
     * @param array $option
     * @return string
     */
    private function select($option) {
        unset($option['label']);
        $default = [
            'name' => '',
            'options' => '',
            'class' => '',
            'id' => '',
            'value' => '',
        ];
        $option = array_merge($default, $option);
        $val = $option['value'];
        unset($option['value']);
        $options = '';
        if (!empty($option['empty'])) {
            $options .= '<option value="">' . $option['empty'] . '</option>';
            unset($option['empty']);
        }
        if (!empty($option['options'])) {
            foreach ($option['options'] as $key => $value) {
                if (!is_array($value)) {
                    if ($val == $key) {
                        $options .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $options .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                } else {
                    $options .= '<optgroup label="' . $key . '">';
                    foreach ($value as $k => $v) {
                        if ($val == $k) {
                            $options .= '<option selected="selected" value="' . $k . '">' . $v . '</option>';
                        } else {
                            $options .= '<option value="' . $k . '">' . $v . '</option>';
                        }
                    }
                    $options .= '</optgroup>';
                }
            }
        }
        unset($option['options']);
        return $this->html->tags('select', $option, true, $options);
    }

    /**
     * 
     * Input do tipo textarea
     * 
     * @param array $option
     * @return string
     */
    private function textarea($option) {
        unset($option['label']);
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
    public function label($label, $options = [], $add = '') {
        $default = [
            'id' => $this->getId($label, 'Label'),
            'class' => '',
            'for' => $this->getId($label),
        ];
        $options = array_merge($default, $options);
        return $this->html->tags('label', $options, true, $add . $label);
    }

    /**
     * 
     * Cria um botão
     * 
     * @param string $name
     * @param array $options
     * @return string
     */
    public function button($name, $options = []) {
        $default = [
            'form' => $this->id,
            'id' => $this->getId($name, 'Button'),
            //'name' => $this->getName($name, 'Button'),
            'type' => 'submit',
            'class' => '',
        ];
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

    /**
     * 
     * Input do tipo text
     * 
     * @param array $option
     * @return string
     */
    private function password($option) {
        unset($option['label']);
        return $this->html->tags('input', $option, false);
    }

}
