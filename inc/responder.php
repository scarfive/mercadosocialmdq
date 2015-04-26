<?php
/*
    responder.php
    
    Permite responder a una pregunta
*/
/* 
    Created on : 25/04/2015, 19:48:46
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
include_once('inc/respuestas.php');
include_once('inc/preguntas.php');

$error = '';

if (!validRequest('codigo')) {
    $error = 'Debe indicar una pregunta donde realizar la respuesta';
}
elseif (!validRequest('respuesta')) {
    $error = 'Debe ingresar una respuesta';
}

if (empty($error)) {
    
    $fecha_actual = time();
    
    $respuesta = new Respuestas();
            
    $respuesta->setFecha(date(sqlDateFormat(), $fecha_actual));
    $respuesta->setPregunta($_REQUEST['codigo']);
    $respuesta->setRespuesta($_REQUEST['respuesta']);
    
    if (!$respuesta->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR ENVIAR LA RESPUESTA');
    }
    
    $pregunta = new Preguntas($_REQUEST['codigo']);
    $pregunta->setRespondida(1);
    
    if (!$pregunta->update()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR ENVIAR LA RESPUESTA');
    }
    
    $alerta = new Alerta('exito', 'SE HA ENVIADO LA RESPUESTA');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>