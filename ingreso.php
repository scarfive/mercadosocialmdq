<?php
/*
    ingreso.php
    
    Formulario de ingreso para los usuarios
*/
/* 
    Created on : 17/04/2015, 22:09:13
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');

?>
<div id="formulario_ingreso" class="cuadro_formulario formulario_angosto personaje_saludo">
    
    <div class="texto_formulario">
        <h1>Bienvenido a Mercado Social de Mar del Plata!</h1>
        <p>Ingrese sus datos y acceda ahora mismo!</p>
    </div>
    
    <?php  
        $formulario = new Formulario('.');
        
        $campo_user = new Campo('u', '', 'Nombre de usuario', 'text');
        $campo_user->add_class('ui-icono-usuario');
        
        $campo_pass = new Campo('p', '', 'Contrase&ntilde;a', 'password');
        $campo_pass->add_class('ui-icono-candado');
        
        $boton = new Boton('ingresar', 'ingresar');
        $boton->add_class('ui-boton-naranja');
        
        $formulario->open();
        
        $campo_user->show();
        $campo_pass->show();
        
        $boton->show();
        
        $formulario->close();
    ?>
    
    <div class="texto_formulario">
        <a href="?form=registro">Nuevo en Mercado Social? Registrese sin cargo alguno!</a>
    </div>
        
</div>