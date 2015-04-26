<?php
/*
  compra_confirmacion.php

  Realiza la confirmacion de una compra
 */
/*
  Created on : 25/04/2015, 22:48:33
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_combo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Confirmaci&oacute;n de compra</h1>

<p>Est&aacute; a punto de comprar el siguiente producto:</p>

<?php include('publicacion_miniatura.php'); ?>

<p>Recuerde que realizar la compra lo obliga a concretar la operaci&oacute;n.</p>
<p>El incumplimiento de este compromiso se ver&aacute; reflejado en su reputaci&oacute;n dentro de Mercado Social.</p>
<p>Si tiene alguna duda respecto a la publicaci&oacute;n o al producto ofrecido, haga todas las preguntas necesarias al vendedor antes de comprar.</p>
<p>Si est&aacute; seguro y desea continuar con la operaci&oacute;n presione el bot&oacute;n <i>comprar</i>.</p>

<?php
    $formulario = new Formulario('?include=usuario&form=compra_realizada');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $_REQUEST['codigo']);
    $campo_codigo->show();
    
    $boton = new Boton('comprar-producto', 'Comprar');
    $boton->add_class('ui-boton-naranja');
    $boton->show();
    
    $formulario->close();
?>