<?php

    class CampoDecimal extends Campo {
        
        public function __construct($name, $value, $label) {
            parent::__construct($name, $value, $label, 'number');
            parent::set_parameters('step="0.01" min="0"');
        }
        
    }

?>