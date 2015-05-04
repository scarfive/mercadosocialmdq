<?php
/*
    borrar_producto.php
    
    Permite borrar un producto
*/
/* 
    Created on : 03/05/2015, 20:16:59
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
include_once('inc/productos.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar un producto para poder borrarlo';
}

$producto = new Productos($_REQUEST['codigo']);

if (empty($error)) {
    
    if (!$producto->delete()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR BORRAR EL PRODUCTO');
    }
    
    $alerta = new Alerta('exito', 'SE HA BORRADO EL PRODUCTO');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>
