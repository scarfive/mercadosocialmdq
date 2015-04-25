<?php
/*
    publicacion_detener.php
    
    Permite detener una publicacion
*/
/* 
    Created on : 23/04/2015, 14:00:18
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Confirmaci&oacute;n de cancelaci&oacute;n</h1>

<p>Desea cancelar la publicaci&oacute;n del siguiente producto?</p>

<?php include('publicacion_miniatura.php'); ?>

<p>El producto no se borrar&aacute;, simplemente no estar&aacute; disponible para su compra.</p>

<?php
    $formulario = new Formulario('?include=usuario&form=listado_productos');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $_REQUEST['codigo']);
    $campo_codigo->show();
    
    $boton = new Boton('cancelar-publicacion', 'cancelar la publicaci&oacute;n');
    $boton->add_class('ui-boton-azul');
    $boton->show();
    
    $formulario->close();
?>