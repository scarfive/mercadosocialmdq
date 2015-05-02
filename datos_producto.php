<?php
/*
    datos_producto.php
    
    Permite visualizar la informacion de un producto
*/
/* 
    Created on : 02/05/2015, 11:18:46
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/publicaciones.php');
    include_once('inc/productos.php');
    include_once('inc/calificaciones.php');
    include_once('inc/lista_calificaciones.php');
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $producto = new Productos($publicacion->getProducto());
    
    $calificaciones = new ListaCalificaciones();
    $calificaciones->setFiltroProducto($producto->getCodigo());
    $calificaciones->cargarLista();
?>

<h1>Informaci&oacute;n sobre:</h1>

<h1><?php print $producto->getDescripcion(); ?></h1>

<p>&nbsp;</p>

<?php 
    if ($calificaciones->getCantidad() > 0) {
        
        foreach ($calificaciones->getCalificaciones() as $calificacion) {

            $producto = new Productos($calificacion->getProducto());
            $usuario = new Usuarios($calificacion->getUsuario());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?include=usuario&form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">De ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Hace '.getTiempoPasado($calificacion->getFecha()).'</p>';

            print '<p class="resaltado"><span class="ui-icono ui-icono-estrella"></span>'.$calificacion->getCalificacion().' de 5 &nbsp;&nbsp; <span class="detalles">[ '.number_format($calificacion->getCalificacion()*20).'% positiva ]</span></p>';
            
            print '<p><span class="ui-icono ui-icono-mensaje"></span>'.$calificacion->getObservaciones().'</p>';

            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h2>Este producto a&uacute;n no ha sido calificado</h2>';
        print '<p>&nbsp;</p>';
    }
?>