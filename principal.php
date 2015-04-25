<?php
/*
    principal.php
    
    El contenedor principal del sitio
    Aqui se carga toda la informacion 
    Contiene los elementos principales a mostrar
*/
/* 
    Created on : 15/04/2015, 15:37:24
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
?>
<div id="principal">
    
    <?php
        if (isset($formulario)) {
            include_once($formulario.'.php'); 
        }
        else {
            include_once('grilla.php'); 
        }
        
    ?>
    
</div>