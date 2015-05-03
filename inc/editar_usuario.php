<?php
/*
    editar_usuario.php
    
    Permite editar la informacion del usuario
*/
/* 
    Created on : 19/04/2015, 03:20:51
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/image_resize.php');
include_once('inc/image_handler.php');

$error = '';

if (!validRequest('apellido')) {
    $error = 'Falta ingresar su apellido';
}
elseif (!validRequest('nombre')) {
    $error = 'Falta ingresar su nombre completo';
}
elseif (!validRequest('domicilio')) {
    $error = 'Falta ingresar su domicilio';
}
elseif (!validRequest('telefono')) {
    $error = 'Falta ingresar su tel&eacute;fono';
}
elseif (!validRequest('correo')) {
    $error = 'Falta ingresar su correo electr&oacute;nico';
}
elseif (!validRequest('resumen')) {
    $error = 'Debe ingresar un resumen sobre lo que hace';
}

if ($_REQUEST['zona'] == 0) {
    $error = 'Debe seleccionar el barrio donde reside';
}

if (isset($_REQUEST['correo']) && $conexion->verificar($usuario->verificarCorreo($_REQUEST['correo']))) {
    $error = 'La direcci&oacute;n de correo ya ha sido registrada';
    unset($_REQUEST['correo']);
}

if (empty($error)) {
    
    $usuario->setApellido($_REQUEST['apellido']);
    $usuario->setNombre($_REQUEST['nombre']);
    $usuario->setDomicilio($_REQUEST['domicilio']);
    $usuario->setTelefono($_REQUEST['telefono']);
    $usuario->setZona($_REQUEST['zona']);
    $usuario->setCorreo($_REQUEST['correo']);
    $usuario->setResumen($_REQUEST['resumen']);
    $usuario->setImagen(TRUE);
    
    if (validRequest($_REQUEST['pass'])) {
        $usuario->setClave($_REQUEST['pass']);
    }

    if (!$usuario->update()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR GUARDAR LOS CAMBIOS');
    }
    
    $alerta = new Alerta('exito', 'SE HAN GUARDADO LOS CAMBIOS');
}
else {
    $alerta = new Alerta('alerta', $error);
}
?>