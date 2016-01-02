<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HtmlHelper
 *
 * @author lucas
 */

namespace Core\Helpers;

use Core\Helpers\Helper;

class HtmlHelper extends Helper {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function br($quantidade = 1) {
        $br = '';
        for ($i = 0; $i < $quantidade; $i++) {
            $br .= '<br />';
        }
        return $br;
    }

    public function icon($icon, $options = array()) {
        return $this->html->tags('i', $options, true, $this->convertArrayInString($icon));
    }

    public function css($url, $options = array()) {
        $default = [
            'href' => $this->request->url($url),
            'rel' => 'stylesheet',
        ];
        return $this->tags('link', array_merge($default, $options), false);
    }

    public function script($url, $options = array()) {
        $default = [
            'src' => $this->request->url($url),
            'rel' => 'text/javascript',
        ];
        return $this->tags('script', array_merge($default, $options));
    }

    public function link($label, $url, $options = array()) {
        $default = [
            'href' => $this->request->url($url),
        ];
        if (isset($options['icon']) and $options['icon'] !== false) {
            $label = $this->icon($options['icon']) . $label;
            unset($options['icon']);
        }
        return $this->tags('a', array_merge($default, $options), true, $label);
    }

    public function url($url = null) {
        return $this->request->url($url);
    }

    public function tags($tag, $options = array(), $close = true, $label = null) {
        $tag = strtolower($tag);
        $return = '<' . $tag . ' ';
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                $return .= \Core\Inflector::parameterize($key) . '="' . $value . '" ';
            }
        }
        if ($close) {
            return $return . '>' . $label . '</' . $tag . '>';
        }
        return $return . '/>';
    }

}
