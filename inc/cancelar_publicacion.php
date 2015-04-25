<?php
/*
    cancelar_publicacion.php
    
    Perite cancelar un publicacion determinada
*/
/* 
    Created on : 23/04/2015, 14:44:49
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/publicaciones.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar una publicaci&oacute;n para poder cancelarla';
}

$publicacion = new Publicaciones($_REQUEST['codigo']);

if (empty($error)) {
    if (!$publicacion->delete()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR CANCELAR LA PUBLICACION');
    }
    $alerta = new Alerta('exito', 'SE HA CANCELADO LA PUBLICACION');
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>