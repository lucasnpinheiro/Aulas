<?php

namespace Core\Database;

use Core\Inflector;

/**
 * Classe que realiza o Entity dos dados que vem do banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Entity {

    //private $contain = [];

    public function __construct() {
        
    }

    public function popula() {
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

    /**
     * 
     * Carrega uma tabela para o controller
     * 
     * @param type $name
     * @return \Core\Controller
     */
    private function loadModel($name) {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $table = '\App\Model\Table\\' . $table;
        return new $table();
    }

    public function contain($str) {
        if (is_array($str)) {
            foreach ($str as $key => $value) {
                $this->contain[$value] = $value;
            }
        } else {
            $this->contain[$str] = $str;
        }
        //return $this;
    }

    public function relacoes() {
        
    }

    public function belongsTo($class, array $options = []) {
        if (!empty($this->contain[$class])) {
            $defautl = [
                'className' => '',
                'foreignKey' => '',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = array_merge($defautl, $options);
            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where($options['foreignKey'], $this->id);
            if (!empty($options['where'])) {
                foreach ($options['where'] as $key => $value) {
                    switch (count($value)) {
                        case 4:
                            $table->where($value[0], $value[1], $value[2], $value[3]);
                            break;
                        case 3:
                            $table->where($value[0], $value[1], $value[2]);
                            break;

                        default:
                            $table->where($value[0], $value[1]);
                            break;
                    }
                }
            }
            if (!empty($options['order'])) {
                foreach ($options['order'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->order($value[0], $value[1]);
                            break;

                        default:
                            $table->order($value[0]);
                            break;
                    }
                }
            }
            if (!empty($options['group'])) {
                foreach ($options['group'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->group($value[0], $value[1]);
                            break;

                        default:
                            $table->group($value[0]);
                            break;
                    }
                }
            }
            $this->{$class} = $table->all();
            unset($this->contain[$class]);
            return $this;
        }
    }

    public function hasOne($class, array $options = []) {
        if (!empty($this->contain[$class])) {
            $defautl = [
                'className' => '',
                'foreignKey' => '',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = array_merge($defautl, $options);
            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where('id', $this->{$options['foreignKey']});
            if (!empty($options['where'])) {
                foreach ($options['where'] as $key => $value) {
                    switch (count($value)) {
                        case 4:
                            $table->where($value[0], $value[1], $value[2], $value[3]);
                            break;
                        case 3:
                            $table->where($value[0], $value[1], $value[2]);
                            break;

                        default:
                            $table->where($value[0], $value[1]);
                            break;
                    }
                }
            }
            if (!empty($options['order'])) {
                foreach ($options['order'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->order($value[0], $value[1]);
                            break;

                        default:
                            $table->order($value[0]);
                            break;
                    }
                }
            }
            if (!empty($options['group'])) {
                foreach ($options['group'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->group($value[0], $value[1]);
                            break;

                        default:
                            $table->group($value[0]);
                            break;
                    }
                }
            }
            $this->{$class} = $table->find();
            unset($this->contain[$class]);
            return $this;
        }
    }

    public function hasMany($class, array $options = []) {
        if (!empty($this->contain[$class])) {
            $defautl = [
                'className' => '',
                'foreignKey' => '',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = array_merge($defautl, $options);
            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where('id', $this->{$options['foreignKey']});
            if (!empty($options['where'])) {
                foreach ($options['where'] as $key => $value) {
                    switch (count($value)) {
                        case 4:
                            $table->where($value[0], $value[1], $value[2], $value[3]);
                            break;
                        case 3:
                            $table->where($value[0], $value[1], $value[2]);
                            break;

                        default:
                            $table->where($value[0], $value[1]);
                            break;
                    }
                }
            }
            if (!empty($options['order'])) {
                foreach ($options['order'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->order($value[0], $value[1]);
                            break;

                        default:
                            $table->order($value[0]);
                            break;
                    }
                }
            }
            if (!empty($options['group'])) {
                foreach ($options['group'] as $key => $value) {
                    switch (count($value)) {
                        case 2:
                            $table->group($value[0], $value[1]);
                            break;

                        default:
                            $table->group($value[0]);
                            break;
                    }
                }
            }
            $this->{$class} = $table->all();
            unset($this->contain[$class]);
            return $this;
        }
    }

}
