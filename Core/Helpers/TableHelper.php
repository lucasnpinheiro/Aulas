<?php

namespace Core\Helpers;

use Core\Helpers\Helper;
use Core\Helpers\HtmlHelper;

/**
 * Classe para criar tabela em HTML
 *
 * @author Lucas Pinheiro
 */
class TableHelper extends Helper {

    /**
     *
     * Carrega a Classe HTML
     * 
     * @var object 
     */
    public $html = null;

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct(\Core\Request $request) {
        parent::__construct($request);
        $this->html = new HtmlHelper($request);
    }

    /**
     * 
     * Cria uma tabela
     * 
     * @param array $options
     * @return string
     */
    public function create($options = []) {
        return $this->html->tags('table', $options, false);
    }

    /**
     * 
     * Cria uma linha
     * 
     * @param string $td
     * @param array $options
     * @return string
     */
    public function tr($td, $options = []) {

        return $this->html->tags('tr', $options, true, $this->convertArrayInString($td));
    }

    /**
     * 
     * Cria uma coluna de header
     * 
     * @param string $value
     * @param array $options
     * @return string
     */
    public function th($value, $options = []) {

        return $this->html->tags('th', $options, true, $this->convertArrayInString($value));
    }

    /**
     * 
     * Cria uma coluna
     * 
     * @param string $value
     * @param array $options
     * @return string
     */
    public function td($value, $options = []) {
        return $this->html->tags('td', $options, true, $this->convertArrayInString($value));
    }

    /**
     * 
     * Cria o corpo da tabela
     * 
     * @param string $tr
     * @param array $options
     * @return string
     */
    public function tbody($tr, $options = []) {
        return $this->html->tags('tbody', $options, true, $this->convertArrayInString($tr));
    }

    /**
     * 
     * Cria o cabeçalho da tabela
     * 
     * @param string $tr
     * @param array $options
     * @return string
     */
    public function thead($tr, $options = []) {
        return $this->html->tags('thead', $options, true, $this->convertArrayInString($tr));
    }

    /**
     * 
     * Cria o rodape da tabela
     * 
     * @param string $tr
     * @param array $options
     * @return string
     */
    public function tfoot($tr, $options = []) {
        return $this->html->tags('tfoot', $options, true, $this->convertArrayInString($tr));
    }

    /**
     * 
     * Cria o caption da tabela
     * 
     * @param string $caption
     * @param array $options
     * @return string
     */
    public function caption($caption, $options = []) {
        return $this->html->tags('caption', $options, true, $this->convertArrayInString($caption));
    }

    /**
     * 
     * Finaliza uma tabela.
     * 
     * @return string
     */
    public function end() {
        return '</table>';
    }

    /**
     * 
     * Convert um array em string
     * 
     * @param string|array $dados
     * @return string
     */
    private function convertArrayInString($dados) {
        if (is_array($dados)) {
            return implode(' ', $dados);
        }
        return $dados;
    }

}
