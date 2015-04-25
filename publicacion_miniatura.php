<?php
/*
    publicacion_miniatura.php
    
    Una publicacion en miniatura
*/
/* 
    Created on : 23/04/2015, 14:40:40
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
?>
<div class="publicacion_miniatura">
    <h2><?php print $producto->getDescripcion(); ?></h2>
    <p>
        <?php
            $img = $producto->getImagenes();
            
            for ($index = 0; $index < 3; $index++) {
                if (!empty($img[$index]['imagen'])) {
                    break;
                }
            }
            
            print getImagen($img[$index]['imagen'], 'img_preview img_preview_left');
            
            print extractoTexto($producto->getResumen()); 
        ?>
    </p>
</div>