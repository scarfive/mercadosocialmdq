<?php
/*
    image_resize.php
    
    Permite redimensionar una imagen
*/
/* 
    Created on : 24/04/2015, 13:54:36
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class ImageResize {
    
    private $nombre_imagen;
    private $DIMENSION_LADO = 260;
    
    public function __construct($img) {
        $this->nombre_imagen = $img;
    }
    
    public function resize() {
        $extension_archivo = explode(".", $this->nombre_imagen);
        $extension = strtolower($extension_archivo[count($extension_archivo)-1]);

        $imagen = NULL;

        if ($extension == 'jpeg' || $extension == 'jpg') {
            $imagen = imagecreatefromjpeg($this->nombre_imagen);
        } 
        else if ($extension == 'gif') {
            $imagen = imagecreatefromgif($this->nombre_imagen);
        } 
        else if ($extension == 'png') {
            $imagen = imagecreatefrompng($this->nombre_imagen);
        }
        else {
            return FALSE;
        }

        $ancho_original = imagesx($imagen);
        $alto_original = imagesy($imagen);

        $relacion = $alto_original/$ancho_original;

        if ($relacion < 1) {
            $alto_nuevo = $this->DIMENSION_LADO;
            $ancho_nuevo = $this->DIMENSION_LADO/$relacion;
        } 
        else {
            $ancho_nuevo = $this->DIMENSION_LADO;
            $alto_nuevo = $this->DIMENSION_LADO*$relacion;
        }

        $margen_x = 0; 
        $margen_y = 0; 

        $temp_img = imagecreatetruecolor($ancho_nuevo, $alto_nuevo);
        $thumb_img = imagecreatetruecolor($this->DIMENSION_LADO, $this->DIMENSION_LADO);

        imagecopyresampled($temp_img, $imagen, 0, 0, 0, 0, $ancho_nuevo, $alto_nuevo, $ancho_original, $alto_original);

        if ($relacion < 1) {
            $margen_x = (imagesx($temp_img)-$this->DIMENSION_LADO)/2;
        }
        else {
            $margen_y = (imagesy($temp_img)-$this->DIMENSION_LADO)/2;
        }

        imagecopy($thumb_img, $temp_img, 0, 0, $margen_x, $margen_y, $this->DIMENSION_LADO, $this->DIMENSION_LADO);

        if ($extension == 'jpeg' || $extension == 'jpg') {
            imagejpeg($thumb_img, $this->nombre_imagen, 90);
        } 
        else if ($extension == 'gif') {
            imagegif($thumb_img, $this->nombre_imagen);
        } 
        else if ($extension == 'png') {
            imagepng($thumb_img, $this->nombre_imagen, 9);
        }

        imagedestroy($imagen);
        imagedestroy($temp_img);
        imagedestroy($thumb_img);
        
        return TRUE;
    }
    
}

?>