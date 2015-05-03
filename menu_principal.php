<?php
/*
    menu_principal.php
    
    El menu principal del sitio
*/
/* 
    Created on : 30/04/2015, 23:22:51
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/campo.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');
?>

<?php
    $form_buscar = new Formulario('.');
    $form_buscar->set_method('GET');
    $form_buscar->add_class('formulario_busqueda');

    $form_buscar->open();
    
    $campo_buscar = new Campo('busqueda', '', 'Buscar', 'text');
    $campo_buscar->add_class('ui-icono-lupa');
    $campo_buscar->show();
    
    $boton = new Boton('buscar', 'buscar');
    $boton->add_class('ui-boton-naranja');
    $boton->show();
    
    $form_buscar->close();
?>

<p>&nbsp;</p>

<h3>Secciones</h3>

<ul class="menu_vertical">
    
    <li>
        <a href="?">
            <img src="img/feliz.png" />
            Ver todo
        </a>
    </li>
    <li>
        <a href="?novedades=true">
            <img src="img/bandera.png" />
            Novedades
        </a>
    </li>
    <li>
        <a href="?visto=true">
            <img src="img/vista.png" />
            Lo m&aacute;s visto
        </a>
    </li>

</ul>

<p>&nbsp;</p>