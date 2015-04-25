<?php

    class Boton {
        
        private $name = NULL;
        private $value = NULL;
        private $class = NULL;
        
        public function __construct($name, $value) {
            $this->name = $name;
            $this->value = $value;
            $this->class = 'ui-boton';
        }
        
        public function get_name() {
            return $this->name;
        }
        
        public function get_value() {
            return $this->value;
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
        
        public function show() {
            print '<input type="submit" name="'.$this->name.'" value="'.$this->value.'" class="'.$this->class.'" />';
        }
        
    }

?>