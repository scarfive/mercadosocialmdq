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

if ($_REQUEST['zona'] == 0) {
    $error = 'Debe seleccionar el barrio donde reside';
}

//$usuario = new Usuarios();

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