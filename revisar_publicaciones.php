<?php
/*
    revisar_publicaciones.php
    
    Permite revisar las publicaciones en busca de las que hayan finalizado
*/
/* 
    Created on : 02/05/2015, 14:40:49
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    include_once('inc/publicaciones.php');
    include_once('inc/lista_publicaciones.php');

    $publicaciones = new ListaPublicaciones();
    $publicaciones->cargarLista();

    foreach ($publicaciones->getPublicaciones() as $publicacion) {
        if (!$publicacion->en_fecha()) {
            $publicacion->setActiva(0);
            $publicacion->update();
        }
    }

?>