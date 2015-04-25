<?php
/*
    publicacion.php
    
    Permite visualizar una publicacion
*/
/* 
    Created on : 22/04/2015, 01:44:26
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/productos.php');
    
    $producto = new Productos($_REQUEST['codigo']);
?>
<div class="publicacion">

    <h1><?php print $producto->getDescripcion(); ?></h1>
    
    <?php
        $imagenes = $producto->getImagenes();
        
        for ($index = 0; $index < sizeof($imagenes); $index++) {
            if (!empty($imagenes[$index]['imagen'])) {
                print getImagen($imagenes[$index]['imagen'], 'img_view');
            }
        }
    ?>

    <p><?php print textoHTML($producto->getResumen()); ?></p>
    
    <p class="precio"><?php print '$'.mostrarPrecio($producto->getPrecio()); ?></p>
    
</div>