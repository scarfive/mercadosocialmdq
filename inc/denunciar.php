<?php
/*
    denunciar.php
    
    Permite asentar una denuncia
*/
/* 
    Created on : 29/04/2015, 17:40:00
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/denuncias.php');

$error = '';

if (!validRequest('operacion')) {
    $error = 'Debe indicar una operaci&oacute;n que denunciar';
}
elseif (!validRequest('publicacion')) {
    $error = 'Debe indicar una publicaci&oacute;n que denunciar';
}
elseif (!validRequest('motivos')) {
    $error = 'Debe ingresar uno o m&aacute;s motivos';
}
elseif (!validRequest('denuncia')) {
    $error = 'Debe expĺicar brevemente el por qu&eactue; de su denuncia';
}
elseif (!validRequest('denunciante')) {
    $error = 'Debe indicar qui&eacute;n realiza la denuncia';
}
elseif (!validRequest('denunciado')) {
    $error = 'Debe indicar hacia qui&eacute;n se dirigue la denuncia';
}

$denuncia = new Denuncias();

if (empty($error)) {
    
    $fecha_actual = time();
    
    $denuncia->setCodigo(getRandomId());
    $denuncia->setFecha(date(sqlDateFormat(), $fecha_actual));
    $denuncia->setDe($_REQUEST['denunciante']);
    $denuncia->setPara($_REQUEST['denunciado']);
    $denuncia->setOperacion($_REQUEST['operacion']);
    $denuncia->setPublicacion($_REQUEST['publicacion']);
    $denuncia->setDenuncia($_REQUEST['denuncia']);
    $denuncia->setMotivos($_REQUEST['motivos']);
    
    if (!$denuncia->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR ENVIAR LA DENUNCIA');
    }
    
    $alerta = new Alerta('exito', 'SE HA ENVIADO LA DENUNCIA');
    
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>