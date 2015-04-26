<?php
/*
    ver_compras.php
    
    Permite visualizar las compras realizadas
*/
/* 
    Created on : 26/04/2015, 01:16:12
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    include_once('inc/lista_operaciones.php');
    
    $operaciones = new ListaOperaciones();
    $operaciones->setFiltroConcretadas();
    $operaciones->setFiltroUsuario($sesion->get_user_id());
    $operaciones->cargarLista();
?>

<h1>Compras realizadas</h1>

<p>Aqu&iacute; puede ver y administrar los productos comprados recientemente:</p>

<?php 
    if ($operaciones->getCantidad() > 0) {
        
        foreach ($operaciones->getOperaciones() as $operacion) {

            $publicacion = new Publicaciones($operacion->getPublicacion());
            $producto = new Productos($publicacion->getProducto());
            $usuario = new Usuarios($producto->getUsuario());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">De ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Comprado hace '.getTiempoPasado($operacion->getFecha()).'</p>';
            
            print '<p class="ayuda">Estas son las acciones que restan completar:</p>';

            $en_contacto = new Enlace('contacto', 'Contactar al vendedor', '?include=usuario&form=escribir_mensaje&codigo='.$producto->getUsuario());
            $en_contacto->add_class('ui-mini-boton ui-boton-verde');
            $en_contacto->show();

            $en_terminar = new Enlace('terminar', 'Compra finalizada', '?include=usuario&form=terminar_compra&codigo='.$producto->getUsuario());
            $en_terminar->add_class('ui-mini-boton ui-boton-naranja');
            $en_terminar->show();

            $en_calificar = new Enlace('calificar', 'Calificar al vendedor', '?include=usuario&form=calificar_usuario&codigo='.$producto->getUsuario());
            $en_calificar->add_class('ui-mini-boton ui-boton-azul');
            $en_calificar->show();

            $en_puntuar = new Enlace('puntuar', 'Calificar al producto', '?include=usuario&form=calificar_producto&codigo='.$producto->getUsuario());
            $en_puntuar->add_class('ui-mini-boton ui-boton-verde');
            $en_puntuar->show();

            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene compras recientes</h1>';
        print '<p>&nbsp;</p>';
    }
?>