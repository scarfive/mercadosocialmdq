<?php
/*
    bienvenida.php

    Pantalla de bienvenida del sistema
 */
/*
    Created on : 18/04/2015, 17:43:37
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
 */

    include_once('inc/boton.php');
    include_once('inc/formulario.php');
    
?>
<div id="formulario_ingreso" class="cuadro_formulario formulario_angosto personaje_saludo">

    <div class="texto_formulario">
        
        <h1>BIENVENIDO A MERCADO SOCIAL DE MAR DEL PLATA!</h1>
        
        <p>
            Ya puede publicar sus productos, comprar, vender, ponerse en contacto con otros 
            productores o artesanos de la ciudad, y armar su tienda virtual para mostrar 
            lo que tiene para ofrecer a la gente.
        </p>
        
        <p>
            Ahora ingrese con su nombre de usuario y contrase&ntilde;a y comience a utilizar nuestro Mercado Social!
        </p>
        
    </div>
    
    <?php
        $formulario = new Formulario('?form=ingreso');
        
        $formulario->open();
        
        $boton = new Boton('entrar', 'ingresar a mercado social');
        $boton->add_class('ui-boton-verde');
        $boton->show();
        
        $formulario->close();
    ?>
    
</div>