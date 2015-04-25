<?php
/*
    grilla.php
    
    Muestra en el sitio un listado de productos
*/
/* 
    Created on : 15/04/2015, 21:04:20
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/publicaciones.php');
include_once('inc/lista_publicaciones.php');
include_once('inc/productos.php');

$publicaciones = new ListaPublicaciones();

if (validRequest('categoria')) {
    $publicaciones->setFiltroCategoria($_REQUEST['categoria']);
}

if (validRequest('usuario')) {
    $publicaciones->setFiltroUsuario($_REQUEST['usuario']);
}

if (validRequest('orden')) {
    switch ($_REQUEST['orden']) {
        case 'fecha':
            $publicaciones->setOrdenFecha();
            break;
        case 'precio':
            $publicaciones->setOrdenPrecio();
            break;
    }
}

$publicaciones->cargarLista();

?>
<div id="grilla_productos">
    
    <?php
        foreach ($publicaciones->getPublicaciones() as $publicacion) {
            $producto = new Productos($publicacion->getProducto());
            include('inc/publicacion_celda.php');
        }
    ?>
    
</div>