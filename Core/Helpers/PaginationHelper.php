<?php

namespace Core\Helpers;

use Core\Helpers\Helper;
use Core\Helpers\HtmlHelper;

/**
 * Classe para geração de formularios.
 *
 * @author Lucas Pinheiro
 */
class PaginationHelper extends Helper {

    public $options = [
        'intervalo' => 5
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
    public function init($options = []) {
        $this->options = \Core\Hash::merge($this->options, $options);
    }

    private function totalLinks() {
        if ($this->options['total'] > $this->options['quantidade']) {
            $this->options['totalLinks'] = (int) ceil($this->options['total'] / $this->options['quantidade']);
        } else {
            $this->options['totalLinks'] = (int) 1;
        }
    }

    private function gerarLinks() {
        $this->options['start'] = ( ($this->options['page'] - $this->options['intervalo']) < 1 ? 1 : ($this->options['page'] - $this->options['intervalo']));
        $this->options['end'] = ( ($this->options['page'] + $this->options['intervalo']) > $this->options['totalLinks'] ? $this->options['totalLinks'] : ($this->options['page'] + $this->options['intervalo']));
        $link = [];
        if (!empty($this->options['totalLinks'])) {
            for ($i = $this->options['start']; $i <= $this->options['end']; $i++) {
                $link[$i] = $this->html->link($i, ['?' => ['page' => $i]], []);
            }
        }
        $this->options['links'] = $link;
    }

    private function render() {
        $v = '<div class="cleanfix"></div>';
        $v .= '<div class="row">';
        $v .= '<div class="col-xs-12 col-md-9 text-center">';
        $v .= ' <ul class="pagination">';
        if (!empty($this->options['links'])) {

            if ($this->options['page'] == 1) {
                $v .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">Início</span></a></li>';
            } else {
                $v .= '<li>' . $this->html->link('<span aria-hidden="true">Início</span>', ['?' => ['page' => 1]], ['aria-label' => 'Previous']) . '</li>';
            }
            foreach ($this->options['links'] as $key => $value) {
                if ($key == $this->options['page']) {
                    $v .= '<li class = "active"><a href = "#">' . $key . ' <span class = "sr-only">(current)</span></a></li>';
                } else {
                    $v .= '<li>' . $value . '</li>';
                }
            }
            if ($this->options['page'] == $this->options['totalLinks']) {
                $v .= '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">Último</span></a></li>';
            } else {
                $v .= '<li>' . $this->html->link('<span aria-hidden="true">Último</span>', ['?' => ['page' => $this->options['totalLinks']]], ['aria-label' => 'Previous']) . '</li>';
            }
        }
        $v .= ' </ul>';
        $v .= '</div>';
        $v .= '<div class="col-xs-12 col-md-3 text-right pagination"><span class="label label-default">';
        $v .= ($this->options['quantidade'] * ($this->options['page'] - 1)) . ' de ' . $this->options['total'];
        $v .= '</span></div>';
        $v .= '</div>';
        $v .= '<div class="cleanfix"></div>';
        return $v;
    }

    public function run() {
        $this->totalLinks();
        $this->gerarLinks();
        return $this->render();
    }

}
