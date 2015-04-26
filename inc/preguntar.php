<?php
/*
    preguntar.php
    
    Realiza una pregunta sobre una publicacion
*/
/* 
    Created on : 25/04/2015, 01:04:38
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
include_once('inc/preguntas.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar una publicaci&oacute;n para realizar la pregunta';
}
elseif (!validRequest('consulta')) {
    $error = 'Debe ingresar una pregunta';
}

if (empty($error)) {
    
    $fecha_actual = time();
    
    $pregunta = new Preguntas();
            
    $pregunta->setFecha(date(sqlDateFormat(), $fecha_actual));
    $pregunta->setPregunta($_REQUEST['consulta']);
    $pregunta->setPublicacion($_REQUEST['codigo']);
    $pregunta->setUsuario($sesion->get_user_id());
    
    if (!$pregunta->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR ENVIAR LA PREGUNTA');
    }
    
    $alerta = new Alerta('exito', 'SE HA ENVIADO LA PREGUNTA');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>