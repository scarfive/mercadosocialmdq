<?php
/*
    menu_cat.php
    
    El menu que contiene las categorias
*/
/* 
    Created on : 15/04/2015, 19:48:38
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

include_once('inc/categorias.php');
include_once('inc/lista_categorias.php');

$lista_categorias = new ListaCategorias();

?>

<h3>Categor&iacute;as</h3>

<ul class="menu_vertical">
    
    <?php
        foreach ($lista_categorias->getCategorias() as $categoria) {
            print '<li><a href="?categoria='.$categoria->getCodigo().'"><img src="img/'.extraerNombre($categoria->getDescripcion()).'.png" />'.$categoria->getDescripcion().'</a></li>';
        }
    ?>

</ul>