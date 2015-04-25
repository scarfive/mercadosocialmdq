<?php
/*
    publicacion_producto.php
    
    Permite realizar la publicacion de un producto
*/
/* 
    Created on : 21/04/2015, 18:05:42
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/enlace.php');
    include_once('inc/productos.php');
    
    $producto = new Productos($_REQUEST['codigo']);
?>

<h1>Publicar un producto</h1>
    
<p>Aqu&iacute; puede ver c&oacute;mo quedar&aacute; publicado su producto:</p>

<p>&nbsp;</p>

<div class="vista_publicacion">

    <?php include('publicacion.php'); ?>

</div>

<div class="barra_opciones">
    <?php
        $en_editar = new Enlace('editar', 'Editar producto', '?include=usuario&form=edicion_producto&codigo='.$_REQUEST['codigo']);
        $en_editar->add_class('ui-boton ui-boton-azul');
        $en_editar->show();
        
        $en_publicar = new Enlace('publicar', 'Publicar producto', '?include=usuario&form=publicacion_confirmacion&codigo='.$_REQUEST['codigo']);
        $en_publicar->add_class('ui-boton ui-boton-naranja');
        $en_publicar->show();
    ?>
</div>