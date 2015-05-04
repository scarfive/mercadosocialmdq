<?php
/*
    borrar_producto.php
    
    Confirmacion de borrado de un producto
*/
/* 
    Created on : 03/05/2015, 19:59:38
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/productos.php');
    include_once('inc/formulario.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/boton.php');

    $producto = new Productos($_REQUEST['codigo']);
?>

<h1>Confirmaci&oacute;n de borrado de producto</h1>

<p>Est&aacute; a punto de borrar el siguiente producto:</p>

<?php include('publicacion_miniatura.php'); ?>

<p>Confirma esta acci&oacute;n?</p>

<p>Una vez que oprima el bot&oacute;n de borrado esta acci&oacute;n no podr&aacute; deshacerse.</p>

<?php
    $formulario = new Formulario('?include=usuario&form=listado_productos');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $producto->getCodigo());
    $campo_codigo->show();
    
    $boton = new Boton('borrar-producto', 'Borrar producto');
    $boton->add_class('ui-boton-azul');
    $boton->show();
    
    $formulario->close();
?>