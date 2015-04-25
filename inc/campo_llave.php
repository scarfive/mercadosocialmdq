<?php

    class CampoLlave extends Campo {
        
        public function __construct($name, $label) {
            parent::__construct($name, '', $label, '');
        }
        
        public function show() {
            print '<div class="switch-body">';
            print '<input type="checkbox" id="'.parent::get_name().'" name="'.parent::get_name().'" class="switch" '.parent::get_required().' '.parent::get_readonly().' '.parent::get_disabled().' '.parent::get_parameters().' />';
            if (!empty(parent::get_label())) {
                print '<label for="'.parent::get_name().'">'.parent::get_label().'</label>';
            }
            print '</div>';
        }
        
    }

?>