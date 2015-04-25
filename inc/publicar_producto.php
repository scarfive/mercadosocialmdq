<?php
/*
    publicar_producto.php
    
    Permite publicar un producto determinado
*/
/* 
    Created on : 22/04/2015, 22:53:10
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/publicaciones.php');
include_once('inc/productos.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar un producto para realizar la publicaci&oacute;n';
}
elseif (!validRequest('tiempo')) {
    $error = 'Debe ingresar el tiempo que quiera mantener la publicaci&oacute;n';
}

if (empty($error)) {
    
    $publicacion = new Publicaciones();
    $producto = new Productos($_REQUEST['codigo']);

    $intervalo = $_REQUEST['tiempo']*7;

    $fecha_actual = time();
    $fecha_limite = strtotime('+'.$intervalo.' day', $fecha_actual);
    
    $publicacion->setCodigo(getRandomId());
    $publicacion->setProducto($_REQUEST['codigo']);
    $publicacion->setPrecio($producto->getPrecio());
    $publicacion->setFecha(date(sqlDateFormat(), $fecha_actual));
    $publicacion->setLimite(date(sqlDateFormat(), $fecha_limite));
    
    if (!$publicacion->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR GUARDAR LA PUBLICACION');
    }
    
    $alerta = new Alerta('exito', 'SE HA PUBLICADO EL PRODUCTO');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>