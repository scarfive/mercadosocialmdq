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

if (validRequest('novedades')) {
    $publicaciones->novedades();
    print '<h1>Ultimas publicaciones realizadas</h1>';
    print '<p>&nbsp;</p>';
}

if (validRequest('visto')) {
    $publicaciones->loMasVisto();
    print '<h1>Las publicaciones m&aacute;s vistas</h1>';
    print '<p>&nbsp;</p>';
}

if (validRequest('busqueda')) {
    $publicaciones->busquedaPorDescripcion($_REQUEST['busqueda']);
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

if (validRequest('limite')) {
    $publicaciones->setLimite($_REQUEST['limite']);
}

if (validRequest('cantidad')) {
    $publicaciones->setCantidad($_REQUEST['cantidad']);
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