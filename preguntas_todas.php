<?php
/*
    preguntas_todas.php
    
    Muestra todas las preguntas de un usuario
*/
/* 
    Created on : 25/04/2015, 21:04:49
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/preguntas.php');
    include_once('inc/respuestas.php');
    include_once('inc/lista_preguntas.php');
    include_once('inc/lista_respuestas.php');
    
    $preguntas = new ListaPreguntas();
    $preguntas->setFiltroRespondidas(TRUE);
    $preguntas->setFiltroUsuario($sesion->get_user_id());
    $preguntas->cargarLista();
?>

<h1>Todas las preguntas realizadas</h1>

<p>Este es el historial de las preguntas que le han hecho y sus respuestas:</p>

<?php 
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
        
        print '<p>PREGUNTA: '.$pregunta->getPregunta().'</p>';
        
        $respuestas = new ListaRespuestas();
        $respuestas->setFiltroPublicacion($publicacion->getCodigo());
        $respuestas->cargarLista();
        
        $respuesta = $respuestas->getSiguienteRespuesta();
        
        print '<p class="detalles">Hace '.getTiempoPasado($respuesta->getFecha()).'</p>';
        
        print '<p>RESPUESTA: '.$respuesta->getRespuesta().'</p>';
        
        print '</div>';
        
    }
?>