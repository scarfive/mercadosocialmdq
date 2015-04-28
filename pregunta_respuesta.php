<?php
/*
    pregunta_respuesta.php
    
    Permite responder a una pregunta
*/
/* 
    Created on : 25/04/2015, 16:47:35
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_texto.php');
    include_once('inc/formulario.php');
    include_once('inc/preguntas.php');
    include_once('inc/publicaciones.php');
    include_once('inc/productos.php');
    
    $pregunta = new Preguntas($_REQUEST['codigo']);
    $publicacion = new Publicaciones($pregunta->getPublicacion());
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Contestar una pregunta</h1>

<p>Aqu&iacute; puede escribir su respuesta:</p>

<?php 
    include('publicacion_miniatura.php');
    
    print '<p>&nbsp;</p>';
    
    print '<p><b>PREGUNTA:</b> '.$pregunta->getPregunta().'</p>';
    
    print '<div class="cuadro_formulario_mensaje">';
    
    $formulario = new Formulario('?include=usuario&form=ver_preguntas');
    $formulario->add_class('formulario_mensaje');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $_REQUEST['codigo']);
    $campo_codigo->show();
    
    $campo_cons = new CampoTexto('respuesta', '', '');
    $campo_cons->add_class('ui-icono-derecha');
    $campo_cons->set_required();
    $campo_cons->show();
    
    $boton = new Boton('enviar-respuesta', 'Hecho!');
    $boton->add_class('ui-boton-azul');
    $boton->show();
    
    $formulario->close();
    
    print '</div>';
?>