<?php
/*
    agregar_producto.php
    
    Permite agregar un nuevo producto
*/
/* 
    Created on : 20/04/2015, 03:15:14
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/image_resize.php');
include_once('inc/image_handler.php');
include_once('inc/productos.php');

$error = '';

if (!validRequest('descripcion')) {
    $error = 'Falta ingresar una descripci&oacute;n';
}
elseif (!validRequest('resumen')) {
    $error = 'Falta ingresar el resumen del producto';
}
elseif (!validRequest('precio')) {
    $error = 'Falta ingresar un precio para el producto';
}
elseif (!validRequest('categorias')) {
    $error = 'Debe seleccionar al menos una categor&iacute;a';
}

$producto = new Productos();

if (empty($error)) {
    
    $producto->setCodigo(getRandomId());
    $producto->setDescripcion($_REQUEST['descripcion']);
    $producto->setResumen($_REQUEST['resumen']);
    $producto->setPrecio($_REQUEST['precio']);
    $producto->setCategorias($_REQUEST['categorias']);
    $producto->setUsuario($sesion->get_user_id());
    
    if (!$producto->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR GUARDAR EL PRODUCTO');
    }
    
    $alerta = new Alerta('exito', 'SE HA GUARDADO EL PRODUCTO');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>