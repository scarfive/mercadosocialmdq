<?php
/*
    publicacion_celda.php
    
    Visualiza una publicacion en forma de celda
*/
/* 
    Created on : 24/04/2015, 00:27:51
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
?>
<div class="publicacion_celda">
    <p class="tiempo">Finaliza en <?php print fechaRelativa($publicacion->getLimite()); ?> d&iacute;as</p>
    <h2><?php print extractoDescripcion($producto->getDescripcion()); ?></h2>
    <p>
        <?php
            $img = $producto->getImagenes();
            
            for ($index = 0; $index < 3; $index++) {
                if (!empty($img[$index]['imagen'])) {
                    break;
                }
            }
            
            print getImagen($img[$index]['imagen'], 'img_preview img_preview_cell');
            
            print '<p class="detalles">';
            
            print $publicacion->getVistas().' vistas | ';
            
            print redondeo($producto->getCalificacion()).' puntos | ';
            
            print $producto->getComentarios().' comentarios';
            
            print '</p>';
            
            print '<p class="precio">'.$publicacion->getPrecio().'</p>';
            
            $en_ver = new Enlace('ver-publicacion', 'ver producto', '?include=publicacion&form=ver_publicacion&codigo='.$publicacion->getCodigo());
            $en_ver->add_class('ui-mini-boton');
            $en_ver->show();
        ?>
    </p>
</div>