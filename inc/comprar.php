<?php
/*
    comprar.php
    
    Permite comprar un producto
*/
/* 
    Created on : 26/04/2015, 00:32:25
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/operaciones.php');
include_once('inc/publicaciones.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar una publicaci&oacute;n en la compra';
}

if (empty($error)) {
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $operacion = new Operaciones();

    $fecha_actual = time();
    
    $operacion->setCodigo(getRandomId());
    $operacion->setComprador($sesion->get_user_id());
    $operacion->setFecha(date(sqlDateFormat(), $fecha_actual));
    $operacion->setMonto($publicacion->getPrecio());
    $operacion->setPublicacion($publicacion->getCodigo());
    
    if (!$operacion->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR REALIZAR LA COMPRA');
    }
    
    $alerta = new Alerta('exito', 'SE HA REALIZADO LA COMPRA');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>