<?php

    class CampoCodigo extends Campo {
        
        public function __construct($name, $value) {
            parent::__construct($name, $value, 'Código:', 'number');
            parent::set_required();
            parent::set_size(13);
            parent::set_maxlength(13);
        }
        
    }

?>