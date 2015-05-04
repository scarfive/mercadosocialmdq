<?php
/*
  imagen.php

  Clase para el manejo de imagenes
 */
/*
  Created on : 21/04/2015, 13:43:22
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */
class Imagen {

    private $image = NULL;
    private $class = 'imagen imagen-muestra';

    public function __construct($image) {
        $this->image = $image;
    }

    public function set_class($class) {
        $this->class = $class;
    }

    public function show() {
        print '<img class="'.$this->class.'" src="'.(empty($this->image) ? 'img/sin-imagen.png' : $this->image).'" />';
    }

}
?>