<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Database;

use Core\Database\Database;

/**
 * Description of Dump
 *
 * @author lucas
 */
class Dump extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function down() {
        $file = ROOT . 'src' . DS . 'dump' . DS . Configure::read('database.banco') . '_' . date('Y_m_d_H_i_s') . '.sql';
        return (bool) $this->pdo->query('mysqldump -u ' . Configure::read('database.usuario') . ' ' . (Configure::read('database.senha') != '' ? '-p' . Configure::read('database.senha') : '') . ' --order-by-primary=TRUE --allow-keywords=TRUE --default-character-set=utf8 --insert-ignore=TRUE --hex-blob=TRUE --force=TRUE --complete-insert=TRUE --skip-triggers ' . Configure::read('database.banco') . ' > ' . $file)->execute();
    }

    public function up($file = '') {
        if (trim($file) == '') {
            $file = Configure::read('database.banco') . '_' . date('Y_m_d_H_i_s');
        }
        $file = ROOT . 'src' . DS . 'dump' . DS . $file;
        $file = trim($file, '.sql') . '.sql';
        return (bool) $this->pdo->query('mysqldump -u ' . Configure::read('database.usuario') . ' ' . (Configure::read('database.senha') != '' ? '-p' . Configure::read('database.senha') : '') . ' ' . Configure::read('database.banco') . ' < ' . $file)->execute();
    }

}
