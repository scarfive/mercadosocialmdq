<?php
/*
    ver_mensajes.php
    
    Permite visualizar todos los mensajes de un usuario
*/
/* 
    Created on : 26/04/2015, 16:15:44
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/mensajes.php');
    include_once('inc/lista_mensajes.php');
    
    $mensajes = new ListaMensajes();
    $mensajes->setFiltroPara($sesion->get_user_id());
    
    if (!validRequest('cantidad')) { 
        $mensajes->setFiltroLeidos();
    }
    
    $mensajes->cargarLista();
?>

<h1>Mensajes</h1>

<p>Aqu&iacute; puede ver y contestar sus mensajes recibidos:</p>

<?php 
    if ($mensajes->getCantidad() > 0) {
        
        if (!validRequest('cantidad')) { 
            
            $pendientes = $mensajes->getCantidad();

            print '<p>&nbsp;</p>';

            print '<h2><span class="ui-icono ui-icono-sobre"></span>Tiene ';

            if ($pendientes > 1) {
                print $pendientes.' mensajes pendientes';
            }
            else {
                print 'un mensaje pendiente';
            }

            print '</h2>';
            
        }

        print '<p>&nbsp;</p>';
        
        $mensajes->agruparPorRemitente();
        $mensajes->setOrdenCodigo('DESC');
        $mensajes->cargarLista();
        
        foreach ($mensajes->getMensajes() as $mensaje) {

            $usuario = new Usuarios($mensaje->getDe());

            print '<div class="cuadro_lista">';

            print '<h2>';

            $mens_usuario = new ListaMensajes();
            $mens_usuario->setFiltroPara($sesion->get_user_id());
            $mens_usuario->setFiltroDe($usuario->getCodigo());
            $mens_usuario->setFiltroLeidos();
            $mens_usuario->cargarLista();
            
            $mens_cantidad = $mens_usuario->getCantidad();
            
            print '<span class="contador">'.$mens_cantidad.'</span>';
            
            print 'Mensaje';
            if ($mens_cantidad != 1) {
                print 's';
            }
            print ' con ';
            
            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?form=ver_usuario&codigo='.$usuario->getCodigo());
            $en_usuario->show();
            
            print '</h2>';
            
            print '<p class="detalles">Ultimo mensaje hace '.getTiempoPasado($mensaje->getFecha()).'</p>';

            print '<p></p>';

            $en_responder = new Enlace('ver', 'Ver mensajes', '?include=usuario&form=mensajes_usuario&codigo='.$usuario->getCodigo());
            $en_responder->add_class('ui-mini-boton ui-boton-naranja');
            $en_responder->show();

            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene mensajes para leer</h1>';
        print '<p>&nbsp;</p>';
    }
    
    if (!validRequest('cantidad')) {
        $en_todas = new Enlace('mensajes-todos', 'Ver todos', '?include=usuario&form=ver_mensajes&cantidad=todos');
        $en_todas->add_class('ui-boton ui-boton-azul');
        $en_todas->show();
    }
?>