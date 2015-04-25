<?php
/*
    menu_encabezado.php
    
    Opciones del encabezado de la pagina
*/
/* 
    Created on : 17/04/2015, 23:08:28
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    include_once('inc/enlace.php');

?>
<div id="menu_encabezado">
    
    <?php
        if($sesion->is_logged()) {
            $en_usuario = new Enlace('usuario', $usuario->getApodo(), '?include=usuario&form=panel');
            $en_usuario->show();
            print '&nbsp;&nbsp;&nbsp;';
            $en_salir = new Enlace('salir', 'salir', '?salir=salir');
            $en_salir->show();
        }
        else {
            $en_ingresar = new Enlace('ingresar', 'Ingresar', '?form=ingreso');
            $en_ingresar->show();
            print '&nbsp;&nbsp;&nbsp;';
            $en_registrar = new Enlace('registrar', 'Registrarse', '?form=registro');
            $en_registrar->show();
        }
    ?>
    
</div>