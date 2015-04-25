<?php

    class CampoEntero extends Campo {
        
        public function __construct($name, $value, $label) {
            parent::__construct($name, $value, $label, 'number');
            parent::set_parameters('step="1" min="0"');
        }
        
    }

?>