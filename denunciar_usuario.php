<?php
/*
    denunciar_usuario.php
    
    denunciar_usuario
*/
/* 
    Created on : 29/04/2015, 20:20:38
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_booleano.php');
    include_once('inc/campo_texto.php');
    include_once('inc/formulario.php');
    include_once('inc/usuarios.php');
    include_once('inc/motivos.php');
    include_once('inc/lista_motivos.php');
    
    $usuario = new Usuarios($_REQUEST['codigo']);

    $lista_motivos = new ListaMotivos();
?>

<h1>Realizar una denuncia</h1>

<p>Aqu&iacute; puede indicar el motivo de su denuncia.</p>

<p>Recuerde que las denuncias radican en un comportamiento inadecuado de un usuario de Mercado Social, 
   comprende maltrato verbal, contenido inadecuado o prohibido para menores, o falta de cumplimiento en 
   las obligaciones de la operaci&oacute;n, como no cumplir con la entrega o el pago de un producto.</p>

<p>&nbsp;</p>

<h2>Su denuncia se radica en la siguiente publicaci&oacute;n:</h2>

<?php include('publicacion_miniatura.php'); ?>

<div class="cuadro_formulario_mensaje">

<?php
    $formulario = new Formulario('?include=usuario&form=denuncia_enviada');
    $formulario->add_class('formulario_mensaje');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $operaciones->getCodigo());
    $campo_codigo->show();
    
    $campo_denunciante = new CampoOculto('denunciante', $sesion->get_user_id());
    $campo_denunciante->show();
    
    $campo_denunciado = new CampoOculto('denunciado', $producto->getUsuario());
    $campo_denunciado->show();
    
    print '<p>Indique uno o m&aacute;s motivos que considere relevantes:</p>';
    
    foreach ($lista_motivos->getMotivos() as $motivo) {
        $campo_motiv = new CampoBooleano('motivos[]', $motivo->getCodigo(), $motivo->getDescripcion());
        print '<p>';
        $campo_motiv->show();
        print '</p>';
    }
    
    print '<p>&nbsp;</p>';
    
    print '<p>Comente aqu&iacute; los fundamentos de su denuncia:</p>';

    $campo_cons = new CampoTexto('denuncia', '', '');
    $campo_cons->add_class('ui-icono-derecha');
    $campo_cons->set_required();
    $campo_cons->show();
    
    $boton = new Boton('realizar-denuncia', 'Denunciar publicaci&oacute;n');
    $boton->add_class('ui-boton-naranja');
    $boton->show();
    
    $formulario->close();
?>

</div>