<?php
/*
    finalizar_compra.php
    
    Permite finalizar un proceso de compra
*/
/* 
    Created on : 28/04/2015, 12:50:03
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/operaciones.php');
include_once('inc/publicaciones.php');
include_once('inc/productos.php');
include_once('inc/puntajes.php');
include_once('inc/calificaciones.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar una publicaci&oacute;n para poder finalizar la compra';
}
elseif (!validRequest('exito')) {
    $error = 'Debe indicar si se ha completado la compra';
}
elseif (!validRequest('puntaje')) {
    $error = 'Debe indicar un puntaje para el vendedor';
}
elseif (!validRequest('obs_vendedor')) {
    $error = 'Debe agregar un comentario sobre el vendedor';
}
elseif (!validRequest('calificacion')) {
    $error = 'Debe indicar un puntaje para el producto';
}
elseif (!validRequest('obs_producto')) {
    $error = 'Debe agregar un comentario sobre el producto';
}

if (empty($error)) {
    
    $operacion = new Operaciones($_REQUEST['codigo']);
    $publicacion = new Publicaciones($operacion->getPublicacion());
    $producto = new Productos($publicacion->getProducto());
    $puntaje = new Puntajes();
    $calificacion = new Calificaciones();

    $fecha_actual = time();
    
    $puntaje->setDe($sesion->get_user_id());
    $puntaje->setFecha(date(sqlDateFormat(), $fecha_actual));
    $puntaje->setObservaciones($_REQUEST['obs_vendedor']);
    $puntaje->setOperacion($operacion->getCodigo());
    $puntaje->setPara($producto->getUsuario());
    $puntaje->setPuntaje($_REQUEST['puntaje']);
    
    if (!$puntaje->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR FINALIZAR LA COMPRA');
    }
    
    $calificacion->setCalificacion($_REQUEST['calificacion']);
    $calificacion->setFecha(date(sqlDateFormat(), $fecha_actual));
    $calificacion->setObservaciones($_REQUEST['obs_producto']);
    $calificacion->setProducto($producto->getCodigo());
    $calificacion->setUsuario($sesion->get_user_id());
    
    if (!$calificacion->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR FINALIZAR LA COMPRA');
    }
    
    $operacion->setConcretada(1);
    
    if (!$operacion->update()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR FINALIZAR LA COMPRA');
    }
    
    $alerta = new Alerta('exito', 'SE HA FINALIZADO LA COMPRA');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>