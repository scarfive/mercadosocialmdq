<?php

    class Campo {
        
        private $name = NULL;
        private $value = NULL;
        private $label = NULL;
        private $type = NULL;
        private $class = NULL;
        private $required = NULL;
        private $readonly = NULL;
        private $disabled = NULL;
        private $size = NULL;
        private $maxlength = NULL;
        private $placeholder = NULL;
        private $parameters = NULL;

        public function __construct($name, $value, $label, $type) {
            $this->name = $name;
            $this->value = $value;
            $this->label = $label;
            $this->placeholder = $label;
            $this->type = $type;
            $this->class = 'ui-campo';
        }
        
        public function get_name() {
            return $this->name;
        }
        
        public function get_value() {
            return $this->value;
        }
        
        public function set_value($value) {
            $this->value = $value;
        }
        
        public function get_label() {
            return $this->label;
        }
        
        public function get_type() {
            return $this->type;
        }
        
        public function get_class() {
            return $this->class;
        }
        
        public function set_class($class) {
            $this->class = $class;
        }
        
        public function add_class($class) {
            $this->class .= ' '.$class;
        }
        
        public function get_required() {
            return $this->required;
        }
        
        public function set_required() {
            $this->required = 'required';
        }
        
        public function get_readonly() {
            return $this->readonly;
        }
        
        public function set_readonly() {
            $this->readonly = 'readonly="readonly"';
        }
        
        public function get_disabled() {
            return $this->disabled;
        }
        
        public function set_disabled() {
            $this->disabled = 'disabled';
        }
        
        public function get_size() {
            return $this->size;
        }
        
        public function set_size($size) {
            $this->size = 'size="'.$size.'"';
        }
        
        public function get_maxlength() {
            return $this->maxlength;
        }
        
        public function set_maxlength($length) {
            $this->maxlength = 'maxlength="'.$length.'"';
        }
        
        public function get_placeholder() {
            return $this->placeholder;
        }
        
        public function set_placeholder($ph) {
            $this->placeholder = $ph;
        }
        
        public function get_parameters() {
            return $this->parameters;
        }
        
        public function set_parameters($param) {
            $this->parameters = $param;
        }
        
        public function show() {
            /*if (!empty($this->label)) {
                print '<label>'.$this->label.'</label>';
            }*/
            print '<input type="'.$this->type.'" name="'.$this->name.'" class="'.$this->class.'" '.$this->size.' '.$this->maxlength.' placeholder="'.$this->placeholder.'" value="'.$this->value.'" '.$this->required.' '.$this->readonly.' '.$this->disabled.' '.$this->parameters.' />';
        }
        
    }

?>