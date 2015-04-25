<?php

    class CampoTexto extends Campo {
        
        private $text = '';

        public function __construct($name, $label, $value) {
            parent::__construct($name, $value, $label, '');
        }
        
        public function set_text($text) {
            $this->text = $text;
        }
        
        public function show() {
            print '<label>'.parent::get_label().'</label>';
            print '<textarea name="'.parent::get_name().'" class="ui-campo ui-campo-texto '.parent::get_class().'" placeholder="'.parent::get_placeholder().'" '.parent::get_required().' '.parent::get_readonly().'>'.parent::get_value().'</textarea>';
        }
        
    }

?>