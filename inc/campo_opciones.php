<?php
/*
  campo_opciones.php

  Un control que muestra varias opciones donde elegir solo una
 */
/*
  Created on : 28/04/2015, 00:04:20
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */
class CampoOpciones extends Campo {
    
    private $opciones = NULL;

    public function __construct($name) {
        parent::__construct($name, '', '', '');
    }
    
    public function setOpciones($opciones) {
        $this->opciones = $opciones;
    }

    public function show() {
        foreach ($this->opciones as $opcion) {
            print '<div class="ui-cuerpo-radio"><input type="radio" name="' . parent::get_name() . '" value="' . $opcion['value'] . '" required="' . parent::get_required() . '" ' . parent::get_readonly() . ' ' . parent::get_disabled() . ' ' . parent::get_parameters() . ' /><span class="ui-mascara-radio"></span>' . $opcion['label'] . '</div>';
        }
    }

}
?>