<?php
/*
    mensajes_usuario.php
    
    Permite visualizar los mensajes de un remitente dado
*/
/* 
    Created on : 26/04/2015, 20:40:41
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
    include_once('inc/mensajes.php');
    include_once('inc/lista_mensajes.php');
    
    $usuario = new Usuarios($_REQUEST['codigo']);
    
    $mensajes = new ListaMensajes();
    $mensajes->setFiltroEntre($sesion->get_user_id(), $usuario->getCodigo());
    $mensajes->setOrdenCodigo('DESC');
    $mensajes->cargarLista();
?>

<h1>Mensajes con <?php print $usuario->getApodo(); ?></h1>

<?php 
    if ($mensajes->getCantidad() > 0) {
        
        $cantidad = $mensajes->getCantidad();

        print '<p>';

        if ($cantidad > 1) {
            print $cantidad;
        }
        else {
            print 'Un';
        }

        print ' mensaje';
        if ($cantidad > 1) {
            print 's';
        }

        print ' en esta conversaci&oacute;n</p>';
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene mensajes en esta conversaci&oacute;n</h1>';
        print '<p>&nbsp;</p>';
    }
    
    print '<div class="cuadro_formulario_mensaje">';
    
    $formulario = new Formulario('?include=usuario&form=mensajes_usuario');
    $formulario->add_class('formulario_mensaje');
    
    $formulario->open();
    
    $campo_codigo = new CampoOculto('codigo', $usuario->getCodigo());
    $campo_codigo->show();
    
    $campo_mensaje = new CampoTexto('mensaje', '', '');
    $campo_mensaje->add_class('ui-icono-derecha');
    $campo_mensaje->set_required();
    $campo_mensaje->show();
    
    $boton = new Boton('enviar-mensaje', 'Enviar mensaje');
    $boton->add_class('ui-boton-verde');
    $boton->show();
    
    $formulario->close();
    
    print '</div>';
    
    if ($mensajes->getCantidad() > 0) {
        
        foreach ($mensajes->getMensajes() as $mensaje) {

            print '<div class="cuadro_lista">';
            
            print '<p class="detalles">De ';
            
            if ($mensaje->getDe() == $usuario->getCodigo()) {
                print $usuario->getApodo();
            }
            else {
                print $sesion->get_user_name();
            }
            
            print '</p>';
            
            print '<p class="detalles">Hace '.getTiempoPasado($mensaje->getFecha()).'</p>';

            print '<p>'.$mensaje->getMensaje().'</p>';

            print '</div>';
            
            if ($mensaje->getDe() == $usuario->getCodigo()) {
                $mensaje->setLeido(1);
                $mensaje->update();
            }
        }
    
    }
?>