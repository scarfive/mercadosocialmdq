<?php
/*
    ver_calificaciones.php
    
    Permite mostrar las calificaciones realizadas
 * 
*/
/* 
    Created on : 01/05/2015, 21:15:45
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/calificaciones.php');
    include_once('inc/lista_calificaciones.php');
    include_once('inc/paginador.php');
    
    $calificaciones = new ListaCalificaciones();
    
    $calificaciones->setFiltroUsuario($sesion->get_user_id());
    
    if (validRequest('inicio')) {
        $calificaciones->setInicio($_REQUEST['inicio']);
    }
    else {
        $calificaciones->setInicio(0);
    }
    
    $calificaciones->setCantidad($_ELEMENTOS_POR_PAGINA);
    
    $calificaciones->cargarLista();
?>

<h1>Calificaciones recibidas</h1>

<p>Aqu&iacute; puede ver las calificaciones recibidas en cada uno de sus productos:</p>

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
        
        $paginador = new Paginador($_ELEMENTOS_POR_PAGINA, $calificaciones->getTotal());
        $paginador->show();
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>Sus productos todav&iacute;a no tienen calificaciones</h1>';
        print '<p>&nbsp;</p>';
    }
?>