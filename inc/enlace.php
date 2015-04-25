<?php

    class Enlace {
        
        private $name = NULL;
        private $value = NULL;
        private $href = NULL;
        private $class = NULL;
        
        public function __construct($name, $value, $href) {
            $this->name = $name;
            $this->value = $value;
            $this->href = $href;
        }
        
        public function get_name() {
            return $this->name;
        }
        
        public function get_value() {
            return $this->value;
        }
        
        public function get_href() {
            return $this->href;
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
            print '<a href="'.$this->href.'" name="'.$this->name.'" class="ui-enlace '.$this->class.'">'.$this->value.'</a>';
        }
        
    }

?>