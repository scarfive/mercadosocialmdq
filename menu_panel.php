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
    include_once('inc/operaciones.php');
    include_once('inc/lista_operaciones.php');
    include_once('inc/mensajes.php');
    include_once('inc/lista_mensajes.php');
    include_once('inc/preguntas.php');
    include_once('inc/lista_preguntas.php');
    
    $operaciones = new ListaOperaciones();
    
    $operaciones->setFiltroConcretadas();
    $operaciones->setFiltroComprador($sesion->get_user_id());
    $operaciones->cargarLista();
    
    $compras_pendientes = $operaciones->getCantidad();
    
    $operaciones->setFiltroConcretadas();
    $operaciones->setFiltroVendedor($sesion->get_user_id());
    $operaciones->cargarLista();
    
    $ventas_pendientes = $operaciones->getCantidad();
    
    $mensajes = new ListaMensajes();
    $mensajes->setFiltroLeidos();
    $mensajes->setFiltroPara($sesion->get_user_id());
    $mensajes->cargarLista();
    
    $mensajes_pendientes = $mensajes->getCantidad();
    
    $preguntas = new ListaPreguntas();
    $preguntas->setFiltroRespondidas();
    $preguntas->setFiltroUsuario($sesion->get_user_id());
    $preguntas->cargarLista();
    
    $preguntas_pendientes = $preguntas->getCantidad();
?>

<h3>Panel de control</h3>

<ul class="menu_vertical">

    <li>
        <a href="?include=usuario&form=datos">
            <img src="img/info.png" />Mis datos
        </a>
    </li>

    <li>
        <a href="?include=usuario&form=listado_productos">
            <img src="img/producto.png" />Mis productos
        </a>
    </li>

    <li>
        <a href="?include=usuario&form=ver_mensajes">
            <img src="img/mensaje.png" />Mensajes
            <?php
                if ($mensajes_pendientes > 0) {
                    print '<span class="indicador_cantidad">'.$mensajes_pendientes.'</span>';
                }
            ?>
        </a>
    </li>

    <li>
        <a href="?include=usuario&form=ver_compras">
            <img src="img/compra.png" />Mis compras
            <?php
                if ($compras_pendientes > 0) {
                    print '<span class="indicador_cantidad">'.$compras_pendientes.'</span>';
                }
            ?>
        </a>
    </li>

    <li>
        <a href="?include=usuario&form=ver_ventas">
            <img src="img/venta.png" />Mis ventas
            <?php
                if ($ventas_pendientes > 0) {
                    print '<span class="indicador_cantidad">'.$ventas_pendientes.'</span>';
                }
            ?>
        </a>
    </li>

<!--    <li><img src="img/estadisticas.png" />Estad&iacute;sticas</li>-->

    <li>
        <a href="?include=usuario&form=ver_puntaje">
            <img src="img/puntaje.png" />Mi puntaje
        </a>
    </li>

    <li>
        <a href="?include=usuario&form=ver_preguntas">
            <img src="img/pregunta.png" />Preguntas
            <?php
                if ($preguntas_pendientes > 0) {
                    print '<span class="indicador_cantidad">'.$preguntas_pendientes.'</span>';
                }
            ?>
        </a>
    </li>
    
    <li>
        <a href="?include=usuario&form=ver_calificaciones">
            <img src="img/calificacion.png" />Calificaciones
        </a>
    </li>

</ul>