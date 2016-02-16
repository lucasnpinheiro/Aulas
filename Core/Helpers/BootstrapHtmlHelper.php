<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Helpers;

use Core\Helpers\HtmlHelper;

/**
 * Description of BootstrapHtmlHelper
 *
 * @author lucas
 */
class BootstrapHtmlHelper extends HtmlHelper {

    public function __construct(\Core\Request $request) {
        parent::__construct($request);
    }

    public function sexo($id) {
        $s = ['M' => 'Masculino', 'F' => 'Feminino'];
        return $s[$id];
    }

    public function genero($id) {
        $s = ['M' => 'Macho', 'F' => 'Femia'];
        return $s[$id];
    }

    public function data($data) {
        $data = $this->convertData($data, '-', '/');
        $data = explode(' ', $data);
        return $data[0];
    }

    public function dataHora($data) {
        return $this->convertData($data, '-', '/');
    }

    public function primeiroNome($string) {
        $exp = explode(' ', trim($string));
        return $exp[0];
    }

    public function linkTel($label, $url, $options = []) {
        $url = 'tel:' . trim(str_replace(['(', ')', ' ', '-'], '', $url));
        return $this->link($label, $url, $options);
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
    public function linkPermissao($label, $url, $options = []) {
        if (!is_array($url)) {
            return $this->link($label, $url, $options);
        }
        $defautl = [
            'action' => $this->request->action,
            'controller' => $this->request->controller,
            'path' => $this->request->path,
            'params' => $this->request->params,
            'query' => $this->request->query,
        ];
        $url = array_merge($defautl, $url);
        $_url = $this->request->prepareUrl($url);
        $Menu = new \App\Model\Table\MenusTable();
        $find = $Menu
                ->where('path', $_url['path'])
                ->where('controller', $_url['controller'])
                ->where('action', $_url['action'])
                ->where((\Core\Session::read('Auth.User.tipo') == 1 ? 'administrador' : 'tosador'), 1)
                ->find();
        if (!empty($find)) {
            return $this->link($label, $url, $options);
        }
        return null;
    }

    public function status($id) {
        $r = [
            '0' => ['class' => 'label label-warning', 'text' => 'Inativo'],
            '1' => ['class' => 'label label-success', 'text' => 'Ativo'],
            '9' => ['class' => 'label label-danger', 'text' => 'Excluido']
        ];
        return '<span class="' . $r[$id]['class'] . '">' . $r[$id]['text'] . '</span>';
    }

}
