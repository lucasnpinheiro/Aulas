<?php

namespace Core\Helpers;

use Core\Helpers\FormHelper;
use Core\Helpers\HtmlHelper;
use Core\Inflector;

/**
 * Classe para geração de formularios.
 *
 * @author Lucas Pinheiro
 */
class BootstrapFormHelper extends FormHelper {

    public function __construct() {
        parent::__construct();
        $this->html = new HtmlHelper();
    }

    public function input($field, $options = array()) {
        if(!isset($options['class'])){
            $options['class'] = '';
        }
        $options['class'] += ' form-control';
        $input = parent::input($field, $options);
        /* <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
          </div> */
        return $this->html->tags('div', array('class'=>'form-group'), true, $input);
    }

}
