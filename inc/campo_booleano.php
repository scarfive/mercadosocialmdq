<?php

    class CampoBooleano extends Campo {
        
        private $checked = FALSE;

        public function __construct($name, $value, $label, $checked = FALSE) {
            parent::__construct($name, $value, $label, '');
            $this->checked = $checked;
        }
        
        public function show() {
            $isChecked = '';
            if ($this->checked) {
                $isChecked = 'checked="checked"';
            }
            print '<div class="ui-cuerpo-checkbox"><input type="checkbox" name="'.parent::get_name().'" value="'.parent::get_value().'" '.$isChecked.'" '.parent::get_required().' '.parent::get_readonly().' '.parent::get_disabled().' '.parent::get_parameters().' /><span class="ui-mascara-checkbox"></span>'.parent::get_label().'</div>';
        }
        
    }

?>