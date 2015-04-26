<?php
/*
    ver_preguntas.php
    
    Permite visualizar las preguntas pendientes
*/
/* 
    Created on : 25/04/2015, 13:00:57
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/preguntas.php');
    include_once('inc/lista_preguntas.php');
    
    $preguntas = new ListaPreguntas();
    $preguntas->setFiltroRespondidas();
    $preguntas->setFiltroUsuario($sesion->get_user_id());
    $preguntas->cargarLista();
?>

<h1>Preguntas pendientes</h1>

<p>Aqu&iacute; puede leer y contestar las preguntas hechas a sus publicaciones:</p>

<?php 
    if ($preguntas->getCantidad() > 0) {
        
        foreach ($preguntas->getPreguntas() as $pregunta) {

            $publicacion = new Publicaciones($pregunta->getPublicacion());
            $producto = new Productos($publicacion->getProducto());
            $usuario = new Usuarios($producto->getUsuario());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">De ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Hace '.getTiempoPasado($pregunta->getFecha()).'</p>';

            print '<p>'.$pregunta->getPregunta().'</p>';

            $en_responder = new Enlace('responder', 'Responder', '?include=usuario&form=pregunta_respuesta&codigo='.$pregunta->getCodigo());
            $en_responder->add_class('ui-mini-boton ui-boton-azul');
            $en_responder->show();

            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene preguntas por responder</h1>';
        print '<p>&nbsp;</p>';
    }
    
    $en_todas = new Enlace('preguntas-todas', 'Ver todas', '?include=usuario&form=preguntas_todas');
    $en_todas->add_class('ui-boton ui-boton-verde');
    $en_todas->show();
?>