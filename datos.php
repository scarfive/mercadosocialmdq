<?php
/*
    datos.php
    
    Formulario de edicion de datos del usuario
*/
/* 
    Created on : 19/04/2015, 00:00:39
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/campo_combo.php');
    include_once('inc/campo_texto.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');
    include_once('inc/zonas.php');
    
    $zonas = new Zonas();
?>

<h1>Datos personales</h1>
    
<p>Aqu&iacute; puede cambiar su informaci&oacute;n personal</p>

<?php  
    $formulario = new Formulario('?include=usuario&form=datos');

    $campo_nombre = new Campo('nombre', '', 'Nombre', 'text');
    $campo_nombre->add_class('ui-icono-derecha');
    $campo_nombre->set_required();
    $campo_nombre->set_value($usuario->getNombre());

    $campo_apellido = new Campo('apellido', '', 'Apellido', 'text');
    $campo_apellido->add_class('ui-icono-derecha');
    $campo_apellido->set_required();
    $campo_apellido->set_value($usuario->getApellido());

    $campo_domicilio = new Campo('domicilio', '', 'Domicilio', 'text');
    $campo_domicilio->add_class('ui-icono-derecha');
    $campo_domicilio->set_required();
    $campo_domicilio->set_value($usuario->getDomicilio());

    $campo_telefono = new Campo('telefono', '', 'Tel&eacute;fono', 'tel');
    $campo_telefono->add_class('ui-icono-derecha');
    $campo_telefono->set_required();
    $campo_telefono->set_value($usuario->getTelefono());

    $campo_correo = new Campo('correo', '', 'Correo electr&oacute;nico', 'email');
    $campo_correo->add_class('ui-icono-derecha');
    $campo_correo->set_required();
    $campo_correo->set_value($usuario->getCorreo());
    
    $campo_zona = new CampoCombo('zona', 'Zona');
    $campo_zona->add_class('ui-icono-derecha');
    $campo_zona->set_required();
    $campo_zona->set_sql_options($conexion->ejecutar($zonas->getZonas()));
    $campo_zona->set_selected_option($usuario->getZona());

    $campo_pass = new Campo('pass', '', 'Nueva contrase&ntilde;a', 'password');
    
    $campo_res = new CampoTexto('resumen', '');
    $campo_res->add_class('ui-icono-derecha');
    $campo_res->set_placeholder('Algo sobre mi o sobre lo que hago');
    $campo_res->set_required();
    $campo_res->set_value($usuario->getResumen());
    
    $campo_img = new Campo('imagen', '', '', 'file');

    $boton = new Boton('editar-usuario', 'guardar cambios');
    $boton->add_class('ui-boton-verde');

    $formulario->open();
    
    print '<p>Informaci&oacute;n personal:</p>';
    
    $campo_nombre->show();
    $campo_apellido->show();
    $campo_domicilio->show();
    $campo_telefono->show();
    $campo_correo->show();
    $campo_zona->show();
    $campo_pass->show();
    
    print '<p>Resumen:</p>';
    
    $campo_res->show();
    
    print getImagen($usuario->getImagen(), 'img_view');
    
    $campo_img->show();

    $boton->show();

    $formulario->close();
?>