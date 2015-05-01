<?php
/*
  realizar_denuncia.php

  Permite realizar una denuncia
 */
/*
  Created on : 29/04/2015, 16:35:50
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */
    include_once('inc/boton.php');
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_booleano.php');
    include_once('inc/campo_texto.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    include_once('inc/motivos.php');
    include_once('inc/lista_motivos.php');
    include_once('inc/usuarios.php');
    
    $codigo = $_REQUEST['codigo'];
    
    $operacion = NULL;
    $publicacion = NULL;
    $producto = NULL;
    $usuario = NULL;
    
    if (validRequest('publicacion')) {
        $publicacion = new Publicaciones($codigo);
        $producto = new Productos($publicacion->getProducto());
        $usuario = new Usuarios($producto->getUsuario());
    }
    elseif (validRequest('operacion')) {
        $operacion = new Operaciones($codigo);
        $publicacion = new Publicaciones($operacion->getPublicacion());
        $producto = new Productos($publicacion->getProducto());
        
        if ($producto->getUsuario() == $sesion->get_user_id()) {
            $usuario = new Usuarios($operacion->getComprador());
        }
        else {
            $usuario = new Usuarios($producto->getUsuario());
        }
    }
    else {
        /* ... */
    }

    $lista_motivos = new ListaMotivos();
?>

<h1>Realizar una denuncia</h1>

<p>Aqu&iacute; puede indicar el motivo de su denuncia.</p>

<p>Recuerde que las denuncias radican en un comportamiento inadecuado de un usuario de Mercado Social, 
   comprende maltrato verbal, contenido inadecuado o prohibido para menores, o falta de cumplimiento en 
   las obligaciones de la operaci&oacute;n, como no cumplir con la entrega o el pago de un producto.</p>

<p>&nbsp;</p>

<h2><span class="ui-icono ui-icono-atencion"></span>Su denuncia es contra el usuario: <?php print $usuario->getApodo(); ?></h2>

<p>&nbsp;</p>

<h2>Y radica en la siguiente publicaci&oacute;n:</h2>

<?php include('publicacion_miniatura.php'); ?>

<div class="cuadro_formulario_mensaje">

<?php
    $formulario = new Formulario('?include=usuario&form=denuncia_enviada');
    $formulario->add_class('formulario_mensaje');
    
    $formulario->open();
    
    $codigo_operacion = 0;
    
    if (!is_null($operacion)) {
        $codigo_operacion = $operacion->getCodigo();
    }
    
    $campo_operacion = new CampoOculto('operacion', $codigo_operacion);
    $campo_operacion->show();
    
    $codigo_publicacion = 0;
    
    if (!is_null($publicacion)) {
        $codigo_publicacion = $publicacion->getCodigo();
    }
    
    $campo_publicacion = new CampoOculto('publicacion', $codigo_publicacion);
    $campo_publicacion->show();
    
    $campo_denunciante = new CampoOculto('denunciante', $sesion->get_user_id());
    $campo_denunciante->show();
    
    $campo_denunciado = new CampoOculto('denunciado', $usuario->getCodigo());
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