<?php
/*
    publicacion_confirmacion.php
    
    Solicita la confirmacion de una publicacion
*/
/* 
    Created on : 22/04/2015, 12:56:28
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_combo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    
    $producto = new Productos($_REQUEST['codigo']);
?>

<h1>Confirmaci&oacute;n de la publicaci&oacute;n del producto</h1>

<?php include('publicacion_miniatura.php'); ?>

<p>Seleccione el tiempo por el cual quiere mantener la publicaci&oacute;n:</p>

<?php
    $formulario = new Formulario('?include=usuario&form=listado_productos');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $_REQUEST['codigo']);
    $campo_codigo->show();
    
    $campo_tiempo = new CampoCombo('tiempo', '');
    $campo_tiempo->add_class('ui-icono-derecha');
    $campo_tiempo->set_required();
    
    $campo_tiempo->add_option('1 semana', 1);
    $campo_tiempo->add_option('2 semanas', 2);
    $campo_tiempo->add_option('3 semanas', 3);
    $campo_tiempo->add_option('4 semanas', 4);
    
    $campo_tiempo->set_selected_option(1);
    
    $campo_tiempo->show();
    
    $boton = new Boton('publicar-producto', 'Listo!');
    $boton->add_class('ui-boton-verde');
    $boton->show();
    
    $formulario->close();
?>