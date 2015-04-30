<?php
/*
    ver_usuario.php
    
    Descripcion del archivo ver_usuario
*/
/* 
    Created on : 28/04/2015, 17:50:54
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/zonas.php');
    include_once('inc/publicaciones.php');
    include_once('inc/lista_publicaciones.php');
    
    $usuario = new Usuarios($_REQUEST['codigo']);
    $zona = new Zonas($usuario->getZona());
    
    $publicaciones = new ListaPublicaciones();
    $publicaciones->setFiltroUsuario($usuario->getCodigo());
    $publicaciones->cargarLista();
    
    $numero_publicaciones = $publicaciones->getCantidad();
?>
    
<h1>Ficha personal de <?php print $usuario->getApodo(); ?></h1>

<p>&nbsp;</p>

<p>Ingres&oacute; a Mercado Social hace <?php print getTiempoPasado($usuario->getAlta()); ?></p>
    
<p>Vive en la zona de <?php print $zona->getZona(); ?></p>

<p>&nbsp;</p>

<p><span class="ui-icono ui-icono-engranaje"></span>Tiene <?php print $numero_publicaciones; ?> publicaciones activas</p>

