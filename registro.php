<?php
/*
    registro.php
    
    Formulario de registro para los usuarios
*/
/* 
    Created on : 17/04/2015, 22:09:13
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/campo.php');
    include_once('inc/campo_combo.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');
    include_once('inc/zonas.php');
    
    $zonas = new Zonas();

?>
<div id="formulario_registro" class="cuadro_formulario formulario_angosto personaje_saludo">
    
    <div class="texto_formulario">
        <h1>Registro de nuevo usuario</h1>
        <p>Complete los siguientes datos para poder registrarse como usuario de Mercado Social:</p>
    </div>
    
    <?php  
        $formulario = new Formulario('.');
        
        $campo_nombre = new Campo('nombre', '', 'Nombre', 'text');
        $campo_nombre->add_class('ui-icono-derecha');
        $campo_nombre->set_required();
        
        if (isset($_REQUEST['nombre'])) {
            $campo_nombre->set_value($_REQUEST['nombre']);
        }
        
        $campo_apellido = new Campo('apellido', '', 'Apellido', 'text');
        $campo_apellido->add_class('ui-icono-derecha');
        $campo_apellido->set_required();
        
        if (isset($_REQUEST['apellido'])) {
            $campo_apellido->set_value($_REQUEST['apellido']);
        }
        
        $campo_domicilio = new Campo('domicilio', '', 'Domicilio', 'text');
        $campo_domicilio->add_class('ui-icono-derecha');
        $campo_domicilio->set_required();
        
        if (isset($_REQUEST['domicilio'])) {
            $campo_domicilio->set_value($_REQUEST['domicilio']);
        }
        
        $campo_telefono = new Campo('telefono', '', 'Tel&eacute;fono', 'tel');
        $campo_telefono->add_class('ui-icono-derecha');
        $campo_telefono->set_required();
        
        if (isset($_REQUEST['telefono'])) {
            $campo_telefono->set_value($_REQUEST['telefono']);
        }
        
        $campo_correo = new Campo('correo', '', 'Correo electr&oacute;nico', 'email');
        $campo_correo->add_class('ui-icono-derecha');
        $campo_correo->set_required();
        
        if (isset($_REQUEST['correo'])) {
            $campo_correo->set_value($_REQUEST['correo']);
        }
        
        $campo_zona = new CampoCombo('zona', 'Zona');
        $campo_zona->add_class('ui-icono-derecha');
        $campo_zona->add_option('Seleccione una zona...');
        $campo_zona->set_required();
        
        if (isset($_REQUEST['zona'])) {
            $campo_zona->set_selected_option($_REQUEST['zona']);
        }
        
        $campo_zona->set_sql_options($conexion->ejecutar($zonas->getZonas()));
        
        $campo_apodo = new Campo('apodo', '', 'Nombre de usuario', 'text');
        $campo_apodo->add_class('ui-icono-derecha');
        $campo_apodo->set_required();
        
        if (isset($_REQUEST['apodo'])) {
            $campo_apodo->set_value($_REQUEST['apodo']);
        }
        
        $campo_pass = new Campo('pass', '', 'Contrase&ntilde;a', 'password');
        $campo_pass->add_class('ui-icono-derecha');
        $campo_pass->set_required();
        
        $boton = new Boton('registrarse', 'registrarse');
        $boton->add_class('ui-boton-azul');
        
        $formulario->open();
        
        $campo_nombre->show();
        $campo_apellido->show();
        $campo_domicilio->show();
        $campo_telefono->show();
        $campo_correo->show();
        $campo_zona->show();
        $campo_apodo->show();
        $campo_pass->show();
        
        $boton->show();
        
        $formulario->close();
    ?>
        
</div>