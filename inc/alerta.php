<?php
/*
    ingreso.php
    
    Formulario de ingreso para los usuarios
*/
/* 
    Created on : 18/04/2015, 15:00:38
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    class Alerta {
        
        private $tipo;
        private $mensaje;

        public function __construct($type = '', $msg = '') {
            $this->tipo = $type;
            $this->mensaje = $msg;
        }
        
        public function setTipo($type) {
            $this->tipo = $type;
        }
        
        public function setMensaje($msg) {
            $this->mensaje = $msg;
        }
        
        public function mostrar() {
            print '<p class="'.$this->tipo.'">';
            print $this->mensaje;
            print '</p>';
        }
        
    }
    
?>