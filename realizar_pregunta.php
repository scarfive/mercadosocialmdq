<?php
/*
    realizar_pregunta.php
    
    Permite realizar una pregunta sobre una publicacion determinada
*/
/* 
    Created on : 24/04/2015, 23:58:51
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_texto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Realizar una pregunta</h1>

<p>Aqu&iacute; puede escribir su consulta para la siguiente publicaci&oacute;n:</p>

<?php include('publicacion_miniatura.php'); ?>

<?php
    $formulario = new Formulario('?include=usuario&form=listado_productos');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $_REQUEST['codigo']);
    $campo_codigo->show();
    
    $campo_cons = new CampoTexto('consulta', '', '');
    $campo_cons->set_required();
    $campo_cons->show();
    
    $boton = new Boton('realizar-pregunta', 'Hecho!');
    $boton->add_class('ui-boton-azul');
    $boton->show();
    
    $formulario->close();
?>