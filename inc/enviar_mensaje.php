<?php
/*
    enviar_mensaje.php

    Permite enviar un mensaje

    Created on : 26/04/2015, 12:41:19
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
 */
include_once('inc/mensajes.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar el usuario a quien enviar el mensaje';
}
elseif (!validRequest('mensaje')) {
    $error = 'Debe ingresar un mensaje';
}

if (empty($error)) {
    
    $fecha_actual = time();
    
    $mensaje = new Mensajes();
            
    $mensaje->setFecha(date(sqlDateFormat(), $fecha_actual));
    $mensaje->setDe($sesion->get_user_id());
    $mensaje->setPara($_REQUEST['codigo']);
    $mensaje->setMensaje($_REQUEST['mensaje']);
    
    if (!$mensaje->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR ENVIAR EL MENSAJE');
    }
    
    $alerta = new Alerta('exito', 'SE HA ENVIADO EL MENSAJE');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>