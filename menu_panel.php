<?php
/*
    menu_panel.php
    
    Menu del panel de control del usuario
*/
/* 
    Created on : 18/04/2015, 23:26:55
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/preguntas.php');
    include_once('inc/lista_preguntas.php');
    
    $preguntas = new ListaPreguntas();
    $preguntas->setFiltroLeidas();
    $preguntas->setFiltroUsuario($sesion->get_user_id());
    $preguntas->cargarLista();
    
    $preguntas_pendientes = $preguntas->getCantidad();
?>

<h3>Opciones</h3>

<ul class="menu_vertical">

    <li><a href="?include=usuario&form=datos"><img src="img/info.png" />Mis datos</a></li>

    <li><a href="?include=usuario&form=listado_productos"><img src="img/producto.png" />Mis productos</a></li>

    <li><img src="img/mensaje.png" />Mensajes</li>

    <li><img src="img/compra.png" />Mis compras</li>

    <li><img src="img/venta.png" />Mis ventas</li>

    <li><img src="img/estadisticas.png" />Estad&iacute;sticas</li>

    <li><img src="img/puntaje.png" />Mi puntaje</li>

    <li><a href="?include=usuario&form=preguntas_realizadas"><img src="img/pregunta.png" />Preguntas
            
    <?php
        if ($preguntas_pendientes > 0) {
            print '<span class="indicador_cantidad">'.$preguntas_pendientes.'</span>';
        }
    ?>

    </a></li>
    
    <li><img src="img/calificacion.png" />Calificaciones</li>

</ul>