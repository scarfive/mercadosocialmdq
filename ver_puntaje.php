<?php
/*
    ver_puntaje.php
    
    Permite ver el puntaje del usuario actual
*/
/* 
    Created on : 01/05/2015, 22:01:54
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    include_once('inc/puntajes.php');
    include_once('inc/lista_puntajes.php');
    
    $puntajes = new ListaPuntajes();
    $puntajes->setFiltroUsuario($sesion->get_user_id());
    $puntajes->cargarLista();
?>

<h1>Puntuaci&oacute;n recibida</h1>

<p>Aqu&iacute; puede ver el puntaje que otros usuarios le han dado dentro de Mercado Social:</p>

<?php 
    if ($puntajes->getCantidad() > 0) {
        
        foreach ($puntajes->getPuntajes() as $puntaje) {

            $operacion = new Operaciones($puntaje->getOperacion());
            $publicacion = new Publicaciones($operacion->getPublicacion());
            $producto = new Productos($publicacion->getProducto());
            $usuario = new Usuarios($puntaje->getDe());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?include=usuario&form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">De ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Hace '.getTiempoPasado($puntaje->getFecha()).'</p>';

            print '<p><span class="ui-icono ui-icono-estrella"></span>'.$puntaje->getPuntaje().' de 5 &nbsp;&nbsp; [ '.number_format($puntaje->getPuntaje()*20).'% positiva ]</p>';
            
            print '<p><span class="ui-icono ui-icono-mensaje"></span>'.$puntaje->getObservaciones().'</p>';

            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>Todav&iacute;a no ha recibido ninguna puntuaci&oacute;n</h1>';
        print '<p>&nbsp;</p>';
    }
?>