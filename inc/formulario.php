<?php

    class Formulario {
        
        private $include = NULL;
        private $form = NULL;
        private $action = NULL;
        private $parameters = NULL;
        private $uri = NULL;
        private $method = NULL;
        private $class = NULL;
        
        public function __construct($action = '') {
            $this->action = $action;
            $this->method = 'POST';
            $this->parameters = array();
        }
        
        public function set_include($include) {
            $this->include = $include;
        }
        
        public function set_form($form) {
            $this->form = $form;
        }
        
        public function set_action($action) {
            $this->action = $action;
        }
        
        public function set_param($param, $value) {
            $this->parameters[] = array('name' => $param, 'value' => $value);
        }
        
        public function set_action_uri($uri) {
            $this->uri = $uri;
        }
        
        public function set_method($method) {
            $this->method = $method;
        }
        
        public function add_class($class) {
            $this->class .= ' '.$class;
        }
        
        public function open() {
            print '<form class="formulario'.$this->class.'" method="'.$this->method.'" enctype="multipart/form-data" action="'.$this->action.'">';
            $this->set_action_parameters();
        }
        
        public function close() {
            print '</form>';
        }
        
        private function set_action_parameters() {
            if (isset($this->parameters) && sizeof($this->parameters) > 0) {
                foreach ($this->parameters as $param) {
                    $campo = new CampoOculto($param['name'], $param['value']);
                    $campo->show();
                }
            }
        }
        
    }

?>