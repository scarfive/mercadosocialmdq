<?php
/*
    enlace_imagen.php
    
    Un enlace con una imagen
*/
/* 
    Created on : 03/05/2015, 18:10:07
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class EnlaceImagen extends Enlace {
    
    private $imagen = NULL;
    private $arriba = FALSE;

    public function __construct($name, $value, $img, $href) {
        parent::__construct($name, $value, $href);
        $this->imagen = $img;
    }
    
    public function setImagenArriba($arriba = TRUE) {
        $this->arriba = $arriba;
    }
    
    public function show() {
        $img = new Imagen($this->imagen);
        $img->set_class('ui-enlace-imagen');
        print '<a';
        print ' href="'.parent::get_href().'"';
        print ' name="'.parent::get_name().'"';
        print ' class="ui-enlace '.parent::get_class().'"';
        print '>';
        $img->show();
        if ($this->arriba) {
            print '<br>';
        }
        print parent::get_value();
        print '</a>';
    }
    
}
?>