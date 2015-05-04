<?php
/*
    registrar.php

    Agregar un registro de usuario
 */
/*
    Created on : 18/04/2015, 17:50:37
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
 */

$error = '';

if (!validRequest('apellido')) {
    $error = 'Falta ingresar su apellido';
}
elseif (!validRequest('nombre')) {
    $error = 'Falta ingresar su nombre completo';
}
elseif (!validRequest('apodo')) {
    $error = 'Debe elegir un nombre de usuario';
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

if ($_REQUEST['zona'] == 0) {
    $error = 'Debe seleccionar el barrio donde reside';
}

$usuario = new Usuarios();

if (isset($_REQUEST['apodo']) && $conexion->verificar($usuario->verificarApodo($_REQUEST['apodo']))) {
    $error = 'El nombre de usuario ya existe';
    unset($_REQUEST['apodo']);
}

if (isset($_REQUEST['correo']) && $conexion->verificar($usuario->verificarCorreo($_REQUEST['correo']))) {
    $error = 'La direcci&oacute;n de correo ya ha sido registrada';
    unset($_REQUEST['correo']);
}

if (empty($error)) {
    
    $usuario->setCodigo(getRandomId());
    $usuario->setApellido($_REQUEST['apellido']);
    $usuario->setNombre($_REQUEST['nombre']);
    $usuario->setApodo($_REQUEST['apodo']);
    $usuario->setDomicilio($_REQUEST['domicilio']);
    $usuario->setTelefono($_REQUEST['telefono']);
    $usuario->setZona($_REQUEST['zona']);
    $usuario->setCorreo($_REQUEST['correo']);
    $usuario->setClave($_REQUEST['pass']);

    if (!$usuario->insert()) {
        $alerta = new Alerta('alerta', 'OCURRIO UN ERROR AL INTENTAR REALIZAR EL REGISTRO');
    }
    
}
else {
    
    $alerta = new Alerta('alerta', $error);

}
?>