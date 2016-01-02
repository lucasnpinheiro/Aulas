<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core;

/**
 * Description of Files
 *
 * @author lucas
 */
class Files {

    //put your code here

    private $file = null;
    private $list = [];

    public function __construct($file = '') {
        $this->file($file);
    }

    public function file($file = '') {
        if (trim($file) != '') {
            $this->file = $file;
        }
    }

    public function read($file = '') {
        $this->file($file);
        if (file_exists($this->file)) {
            return file_get_contents($this->file);
        }
        return null;
    }

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

    public function find($dir, $include_path = FALSE, $recursion = FALSE) {
        if ($fp = opendir($dir)) {
            // reset the array and make sure $source_dir has a trailing slash on the initial call
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

    public function name() {
        return basename($this->file);
    }

    public function path() {
        return $this->file;
    }

    public function size() {
        return filesize($this->file);
    }

    public function date() {
        return filemtime($this->file);
    }

    public function readable() {
        return is_readable($this->file);
    }

    public function writable() {
        return is_writable($this->file);
    }

    public function executable() {
        return is_executable($this->file);
    }

    public function fileperms() {
        return fileperms($this->file);
    }

    public function extension() {
        return end(explode('.', $this->file));
    }

}
