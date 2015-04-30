<?php
/*
    compra_terminar.php
    
    Permite indicar si una compra ha terminado
*/
/* 
    Created on : 27/04/2015, 23:48:45
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_opciones.php');
    include_once('inc/campo_texto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    
    $operacion = new Operaciones($_REQUEST['codigo']);
    $publicacion = new Publicaciones($operacion->getPublicacion());
    $producto = new Productos($publicacion->getProducto());
?>

<h1>Finalizar el proceso de compra</h1>

<p>Aqu&iacute; puede indicar el resultado de su compra y calificar tanto al vendedor como al producto:</p>

<?php include('publicacion_miniatura.php'); ?>

<div class="cuadro_formulario_mensaje">

<?php
    $opciones_si_no = array( array('label' => 'SI', 'value' => 'si'), array('label' => 'NO', 'value' => 'no') );
    
    $puntajes = array( 
            array('label' => '1 &bigstar;', 'value' => '1'), 
            array('label' => '2 &bigstar;&bigstar;', 'value' => '2'), 
            array('label' => '3 &bigstar;&bigstar;&bigstar;', 'value' => '3'), 
            array('label' => '4 &bigstar;&bigstar;&bigstar;&bigstar;', 'value' => '4'), 
            array('label' => '5 &bigstar;&bigstar;&bigstar;&bigstar;&bigstar;', 'value' => '5') 
        );

    $formulario = new Formulario('?include=usuario&form=compra_terminada');
    $formulario->add_class('formulario_mensaje');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $operacion->getCodigo());
    $campo_codigo->show();
    
    print '<h2>Se ha concretado con &eacute;xito la compra?</h2>';
    
    print '<p class="texto">Teniendo en cuenta si ha podido recibir el producto comprado y si ha podido pagar la suma acordada por el mismo.</p>';
    
    $campo_exito = new CampoOpciones('exito');
    $campo_exito->setOpciones($opciones_si_no);
    $campo_exito->set_required();
    $campo_exito->show();
    
    print '<p>&nbsp;</p>';
    
    print '<h2>Qu&eacute; puntaje dar&iacute;a al vendedor?</h2>';
    
    print '<p class="texto">Teniendo en cuenta el desenvolvimiento del mismo durante toda la operaci&oacute;n y la atenci&oacute;n que ha recibido por parte de &eacute;l.</p>';
    print '<p class="texto">☛ Siendo 1 (uno) el menor puntaje posible y 5 (cinco) el mayor puntaje de la escala.</p>';
    
    $campo_puntaje = new CampoOpciones('puntaje');
    $campo_puntaje->setOpciones($puntajes);
    $campo_puntaje->set_required();
    $campo_puntaje->show();
    
    print '<p>&nbsp;</p>';
    
    print '<h2>Comentenos algo sobre su experiencia con este vendedor:</h2>';
    
    $campo_obs_vendedor = new CampoTexto('obs_vendedor', '', '');
    $campo_obs_vendedor->add_class('ui-icono-derecha');
    $campo_obs_vendedor->set_required();
    $campo_obs_vendedor->show();
    
    print '<p>&nbsp;</p>';
    
    print '<h2>Qu&eacute; puntaje dar&iacute;a al producto?</h2>';
    
    print '<p class="texto">☛ Siendo 1 (uno) el menor puntaje posible y 5 (cinco) el mayor puntaje de la escala.</p>';
    
    $campo_calificacion = new CampoOpciones('calificacion');
    $campo_calificacion->setOpciones($puntajes);
    $campo_calificacion->set_required();
    $campo_calificacion->show();
    
    print '<p>&nbsp;</p>';
    
    print '<h2>Comentenos algo sobre este producto que quiera contarle a los dem&aacute;s:</h2>';
    
    $campo_obs_producto = new CampoTexto('obs_producto', '', '');
    $campo_obs_producto->add_class('ui-icono-derecha');
    $campo_obs_producto->set_required();
    $campo_obs_producto->show();
    
    print '<p>&nbsp;</p>';
    
    $boton = new Boton('finalizar-compra', 'Hecho!');
    $boton->add_class('ui-boton-verde');
    $boton->show();
    
    $formulario->close();
?>

</div>