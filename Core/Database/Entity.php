<?php

namespace Core\Database;

use Core\Inflector;

/**
 * Classe que realiza o Entity dos dados que vem do banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Entity {

    public function __construct() {
        $m = get_class_methods($this);
        if (!empty($m)) {
            foreach ($m as $key => $value) {
                if (substr($value, 0, 2) != '__') {
                    if (substr($value, 0, 4) === '_set') {
                        $v = substr($value, 4, -1);
                        $this->{$value}($this->{$v});
                    }
                    if (substr($value, 0, 4) === '_get') {
                        $this->{$value}();
                    }
                }
            }
        }
    }

}
