<?php

namespace Core\Database;

/**
 * Classe que realiza o Entity dos dados que vem do banco de dados informado.
 *
 * @author Lucas Pinheiro
 */
class Entity {

    private $contain = [];
    private $schema = [];

    public function __construct() {
        
    }

    public function __destruct() {
        unset($this->schema);
        unset($this->contain);
    }

    public function setSchema($schema) {
        $this->schema = $schema;
    }

    public function __set($name, $value) {
        if ($value === '' OR is_null($value)) {
            $this->{$name} = null;
        } else {
            switch ($this->_type($name)) {
                case 'int':
                case 'integer':
                    $this->{$name} = (int) $value;
                    break;

                case 'float':
                case 'double':
                case 'decimal':
                    $this->{$name} = (float) $value;
                    break;

                case 'boolean':
                case 'bit':
                    $this->{$name} = (bool) $value;
                    break;

                default:
                    if (is_string($value)) {
                        if (strtolower($value) === 'false') {
                            $this->{$name} = (bool) false;
                        } else if (strtolower($value) === 'true') {
                            $this->{$name} = (bool) true;
                        } else {
                            $this->{$name} = $value;
                        }
                    } else {
                        $this->{$name} = $value;
                    }
                    break;
            }
        }
    }

    private function _type($name) {
        if (!empty($this->schema[$name])) {
            $type = explode('(', $this->schema[$name]);
            return $type[0];
        }
        return 'varchar';
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
    protected function loadModel($name) {
        $table = str_replace('Table', '', $name) . 'Table';
        $name = str_replace('Table', '', $name);
        $table = '\App\Model\Table\\' . $table;
        return new $table();
    }

    public function contain($str) {
        if (is_array($str)) {
            foreach ($str as $key => $value) {
                if (is_array($value)) {
                    $this->contain[$key] = $value;
                } else {
                    $this->contain[$value] = $value;
                }
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
                'from' => '*',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = \Core\Hash::merge($defautl, $options);
            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where($options['foreignKey'], $this->{$table->primary_key});
            if (is_array($this->contain[$class])) {
                $extra = $this->contain[$class];
                if (!empty($extra['contain'])) {
                    $table->contain($extra['contain']);
                    unset($extra['contain']);
                }
                $options = \Core\Hash::merge($options, $extra);
            }

            $this->{$class} = $table->all($options);
            unset($this->contain[$class]);
            return $this;
        }
    }

    public function hasOne($class, array $options = []) {
        if (!empty($this->contain[$class])) {

            $defautl = [
                'className' => '',
                'foreignKey' => '',
                'from' => '*',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = \Core\Hash::merge($defautl, $options);

            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where($table->primary_key, $this->{$options['foreignKey']});
            if (is_array($this->contain[$class])) {
                $extra = $this->contain[$class];
                if (!empty($extra['contain'])) {
                    $table->contain($extra['contain']);
                    unset($extra['contain']);
                }
                $options = \Core\Hash::merge($options, $extra);
            }
            $this->{$class} = $table->find($options);
            unset($this->contain[$class]);
            return $this;
        }
    }

    public function hasMany($class, array $options = []) {
        if (!empty($this->contain[$class])) {
            $defautl = [
                'className' => '',
                'foreignKey' => '',
                'from' => '*',
                'where' => [],
                'order' => [],
                'group' => [],
            ];
            $options = \Core\Hash::merge($defautl, $options);
            if (empty($options['className'])) {
                $options['className'] = $class;
            }
            $table = $this->loadModel($options['className']);
            $table->where($table->primary_key, $this->{$options['foreignKey']});
            if (is_array($this->contain[$class])) {
                $extra = $this->contain[$class];
                if (!empty($extra['contain'])) {
                    $table->contain($extra['contain']);
                    unset($extra['contain']);
                }
                $options = \Core\Hash::merge($options, $extra);
            }
            $this->{$class} = $table->all($options);
            unset($this->contain[$class]);
            return $this;
        }
    }

}
