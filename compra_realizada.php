<?php
/*
    compra_realizada.php
    
    Indica que la compra ha sido realizada
*/
/* 
    Created on : 26/04/2015, 00:23:35
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/productos.php');
    
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Felicitaciones!</h1>

<p>Acaba de comprar el siguiente producto:</p>

<?php include('publicacion_miniatura.php'); ?>

<p>P&oacute;ngase en contacto con el vendedor para acordar los detalles de la operaci&oacute;n y as&iacute; poder pagar y retirar su producto</p>

<?php
    $en_ver = new Enlace('ver-compras', 'Ir a mis compras', '?include=usuario&form=ver_compras');
    $en_ver->add_class('ui-boton ui-boton-verde');
    $en_ver->show();
?>