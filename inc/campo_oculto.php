<?php

    class CampoOculto extends Campo {
        
        public function __construct($name, $value) {
            parent::__construct($name, $value, '', '');
        }

        public function show() {
            print '<input type="hidden" name="'.parent::get_name().'" value="'.parent::get_value().'" />';
        }
        
    }

?>