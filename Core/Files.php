<?php

namespace Core;

/**
 * Classe para manipular arquivos.
 *
 * @author Lucas Pinheiro
 */
class Files {

    /**
     *
     * Nome do arquivo
     * 
     * @var string 
     */
    private $file = null;

    /**
     * 
     * Lista de arquivos ou diretorios que foram localizados.
     *
     * @var array 
     */
    private $list = [];

    /**
     * Função de auto execução ao startar a classe.
     */
    public function __construct($file = '') {
        $this->file($file);
    }

    /**
     * 
     * Adiciona o arquivo
     * 
     * @param string $file
     */
    public function file($file = '') {
        if (trim($file) != '') {
            $this->file = $file;
        }
    }

    /**
     * 
     * Exibe o conteudo do arquivo
     * 
     * @param string $file
     * @return string|null
     */
    public function read($file = '') {
        $this->file($file);
        if (file_exists($this->file)) {
            return file_get_contents($this->file);
        }
        return null;
    }

    /**
     * 
     * Escreve em um arquivo
     * 
     * @param array|string $data
     * @param string $mode
     * @param string $file
     * @return boolean|null
     */
    public function write($data, $mode = 'wb', $file = '') {
        $this->file($file);
        if (!is_null($this->file)) {
            if (!$fp = fopen($this->file, $mode)) {
                return FALSE;
            }
            flock($fp, LOCK_EX);
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    fwrite($fp, $value);
                }
            } else {
                fwrite($fp, $data);
            }
            flock($fp, LOCK_UN);
            fclose($fp);
            return true;
        }
        return null;
    }

    /**
     * 
     * Lista os arquivos de um determinado diretorio
     * 
     * @param string $dir
     * @param boolean $include_path
     * @param boolean $recursion
     * @return boolean|array
     */
    public function find($dir, $include_path = FALSE, $recursion = FALSE) {
        if ($fp = opendir($dir)) {
            if ($recursion === FALSE) {
                $this->list = array();
                $dir = rtrim(realpath($dir), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }
            while (FALSE !== ($file = readdir($fp))) {
                if (is_dir($dir . $file) && $file[0] !== '.') {
                    $this->find($dir . $file . DIRECTORY_SEPARATOR, $include_path, TRUE);
                } elseif ($file[0] !== '.') {
                    $this->list[] = ($include_path === TRUE) ? $dir . $file : $file;
                }
            }
            closedir($fp);
            $list = $this->list;
            $this->list = array();
            return $list;
        }
        return FALSE;
    }

    /**
     * 
     * Retorna o nome do arquivo
     * 
     * @return string
     */
    public function name() {
        return basename($this->file);
    }

    /**
     * 
     * Retorna o diretorio do arquivo
     * 
     * @return string
     */
    public function path() {
        return $this->file;
    }

    /**
     * 
     * Retorna o tamanho do arquivo
     * 
     * @return float
     */
    public function size() {
        return filesize($this->file);
    }

    /**
     * 
     * Retorna a data de criação do arquivo
     * 
     * @return string
     */
    public function date() {
        return filemtime($this->file);
    }

    /**
     * 
     * Verifica se o arquivo pode ser lido
     * 
     * @return boolean
     */
    public function readable() {
        return is_readable($this->file);
    }

    /**
     * 
     * Verifica se o arquivo pode ser escrito
     * 
     * @return boolean
     */
    public function writable() {
        return is_writable($this->file);
    }

    /**
     * 
     * Verifica se o arquivo pode ser executado
     * 
     * @return boolean
     */
    public function executable() {
        return is_executable($this->file);
    }

    /**
     * 
     * Retorna as permissões do arquivo
     * 
     * @return string
     */
    public function fileperms() {
        return fileperms($this->file);
    }

    /**
     * 
     * Retorna a extensão do arquivo
     * 
     * @return string
     */
    public function extension() {
        return end(explode('.', $this->file));
    }

}
