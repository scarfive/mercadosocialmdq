<?php
/*
    escribir_mensaje.php
    
    Permite escribir un mensaje
*/
/* 
    Created on : 26/04/2015, 12:27:37
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/enlace.php');
    include_once('inc/campo.php');
    include_once('inc/campo_texto.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/formulario.php');
    include_once('inc/usuarios.php');
    
    $usuario = new Usuarios($_REQUEST['codigo']);
    
    $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?form=ver_usuario&codigo='.$usuario->getCodigo());
?>

<h1>Enviar un mensaje</h1>

<p>Aqu&iacute; puede escribir y enviar su mensaje:</p>

<p>&nbsp;</p>

<p><span class="ui-icono ui-icono-lapiz"></span>Mensaje para <?php print $en_usuario->show(); ?></p>

<div class="cuadro_formulario_mensaje">

    <?php
        $formulario = new Formulario('?include=usuario&form=ver_compras');
        $formulario->add_class('formulario_mensaje');

        $formulario->open();

        $campo_codigo = new CampoOculto('codigo', $usuario->getCodigo());
        $campo_codigo->show();

        $campo_mensaje = new CampoTexto('mensaje', '', '');
        $campo_mensaje->add_class('ui-icono-derecha');
        $campo_mensaje->set_required();
        $campo_mensaje->show();

        $boton = new Boton('enviar-mensaje', 'Enviar');
        $boton->add_class('ui-boton-azul');
        $boton->show();

        $formulario->close();
    ?>

</div>