<?php

namespace Core\Helpers;

use Core\Helpers\Helper;

/**
 * Classe para gerencial os Helper
 *
 * @author Lucas Pinheiro
 */
class HtmlHelper extends Helper {

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct(\Core\Request $request) {
        parent::__construct($request);
    }

    /**
     * 
     * Função que retorna uma string informada pela quantidade
     * 
     * @param int $quantidade
     * @return string
     */
    public function br($quantidade = 1) {
        $br = '';
        for ($i = 0; $i < $quantidade; $i++) {
            $br .= '<br />';
        }
        return $br;
    }

    public function h($val, $size = 1, $options = array()) {
        return $this->tags('h' . $size, $options, true, $val);
    }

    /**
     * 
     * Cria um icone
     * 
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function moeda($val) {
        return $this->money($val);
    }

    /**
     * 
     * Cria um icone
     * 
     * @param string $icon
     * @param array $options
     * @return string
     */
    public function icon($icon, $options = []) {
        return $this->html->tags('i', $options, true, $this->convertArrayInString($icon));
    }

    /**
     * 
     * cria uma url para chamar um arquivo CSS
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
    public function image($url, $options = []) {
        $id = 'img-' . \Core\Inflector::underscore(\Core\Inflector::camelize(str_replace('/', '/', $url)));
        $default = [
            'src' => $this->request->url($url),
            'alt' => '',
            'title' => '',
            'id' => $id,
        ];
        return $this->tags('img', array_merge($default, $options), false);
    }

    /**
     * 
     * cria uma url para chamar um arquivo CSS
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
    public function css($url, $options = []) {
        $default = [
            'href' => $this->request->url($url),
            'rel' => 'stylesheet',
        ];
        return $this->tags('link', array_merge($default, $options), false);
    }

    /**
     * 
     * cria uma url para chamar um arquivo script como exemplo javascript
     * 
     * @param string $url
     * @param array $options
     * @return string
     */
    public function script($url, $options = []) {
        $default = [
            'src' => $this->request->url($url),
            'type' => 'text/javascript',
        ];
        return $this->tags('script', array_merge($default, $options));
    }

    /**
     * 
     * Cria um link
     * 
     * @param string $label
     * @param string $url
     * @param array $options
     * @return string
     */
    public function link($label, $url, $options = []) {
        if (is_array($url)) {
            $defautl = [
                'action' => $this->request->action,
                'controller' => $this->request->controller,
                'path' => $this->request->path,
                    //'params' => $this->request->params,
                    //'query' => $this->request->query,
            ];
            $url = array_merge($defautl, $url);
        }
        $default = [
            'href' => $this->url($url),
        ];

        if (isset($options['icon']) and $options['icon'] !== false) {
            $label = $this->icon($options['icon']) . $label;
            unset($options['icon']);
        }
        return $this->tags('a', array_merge($default, $options), true, $label);
    }

    /**
     * 
     * Cria uma url
     * 
     * @param string $url
     * @return string
     */
    public function url($url = null) {
        return $this->request->url($url);
    }

    /**
     * 
     * Cria uma tag HTML
     * 
     * @param string $tag
     * @param array $options
     * @param boolean $close
     * @param string $label
     * @return string
     */
    public function tags($tag, $options = [], $close = true, $label = null) {
        $tag = strtolower($tag);
        $return = '<' . $tag . ' ';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                $key = (string) $key;
                $return .= \Core\Inflector::parameterize($key) . '="' . trim($value) . '" ';
            }
        }
        if ($close) {
            return $return . '>' . $label . '</' . $tag . '>';
        }
        return $return . '/>';
    }

    public function data($data) {
        return $this->convertData($data, $separador = '-', $include = '/');
    }

}
