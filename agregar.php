<?php
/*
    agregar.php
    
    Formulario que permite agregar un producto
*/
/* 
    Created on : 19/04/2015, 23:39:50
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/campo.php');
    include_once('inc/campo_texto.php');
    include_once('inc/campo_decimal.php');
    include_once('inc/campo_booleano.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');
    include_once('inc/categorias.php');
    include_once('inc/lista_categorias.php');
?>

<h1>Agregar un nuevo producto</h1>

<p>Complete los siguientes datos para poder agregar un producto a su lista personal:</p>

<?php  
    $formulario = new Formulario('?include=usuario&form=listado_productos');

    $campo_desc = new Campo('descripcion', '', 'Descripci&oacute;n', 'text');
    $campo_desc->add_class('ui-icono-derecha');
    $campo_desc->set_required();

    if (isset($_REQUEST['descripcion'])) {
        $campo_desc->set_value($_REQUEST['descripcion']);
    }

    $campo_res = new CampoTexto('resumen', '');
    $campo_res->add_class('ui-icono-derecha');
    $campo_res->set_placeholder('Resumen del producto');
    $campo_res->set_required();

    if (isset($_REQUEST['resumen'])) {
        $campo_res->set_value($_REQUEST['resumen']);
    }

    $campo_pre = new CampoDecimal('precio', '', 'Precio');
    $campo_pre->add_class('ui-icono-derecha');
    $campo_pre->set_required();

    if (isset($_REQUEST['precio'])) {
        $campo_pre->set_value($_REQUEST['precio']);
    }

    $campos_cat = array();
    
    $categorias = new ListaCategorias();
    $lista_categorias = $categorias->getCategorias();
    
    foreach ($lista_categorias as $cat) {
        $campos_cat[] = new CampoBooleano('categorias[]', $cat->getCodigo(), $cat->getDescripcion());
    }
    
    $boton = new Boton('agregar-producto', 'agregar producto');
    $boton->add_class('ui-boton-naranja');

    $formulario->open();

    $campo_desc->show();
    $campo_res->show();
    $campo_pre->show();
    
    print '<p>Categor&iacute;as:</p>';
    
    foreach ($campos_cat as $campo) {
        $campo->show();
    }
    
    print '<p>Im&aacute;genes:</p>';
    
    $campo_img_1 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_1->show();
    $campo_img_2 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_2->show();
    $campo_img_3 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_3->show();

    $boton->show();

    $formulario->close();
?>