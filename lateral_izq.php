<?php
/*
    lateral_izq.php
    
    El menu lateral izquierdo del sitio
*/
/* 
    Created on : 15/04/2015, 15:33:40
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
?>
<div id="lateral_izq" class="lateral">
    
    <div class="cuadro_opciones">
        
        <?php 
            if (isset($include)) {
                if ($include == 'usuario') {
                    include_once('menu_panel.php'); 
                }
                if ($include == 'publicacion') {
                    include_once('menu_categorias.php'); 
                }
                if ($include == 'categorias') {
                    include_once('menu_categorias.php'); 
                }
            }
            else {
                include('menu_categorias.php'); 
            }
        ?>
        
    </div>
    
</div>