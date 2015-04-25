<?php
/*
    edicion_producto.php
    
    Permite editar un producto
*/
/* 
    Created on : 20/04/2015, 19:14:05
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    include_once('inc/campo.php');
    include_once('inc/campo_texto.php');
    include_once('inc/campo_decimal.php');
    include_once('inc/campo_booleano.php');
    include_once('inc/campo_oculto.php');
    include_once('inc/boton.php');
    include_once('inc/formulario.php');
    include_once('inc/productos.php');
    include_once('inc/categorias.php');
    include_once('inc/lista_categorias.php');
    
    $producto = new Productos($_REQUEST['codigo']);
?>

<h1>Datos del producto</h1>
    
<p>Aqu&iacute; puede cambiar la informaci&oacute;n de un producto guardado</p>

<?php  
    $formulario = new Formulario('?include=usuario&form=listado_productos');
    
    $campo_cod = new CampoOculto('codigo', $_REQUEST['codigo']);

    $campo_desc = new Campo('descripcion', $producto->getDescripcion(), 'Descripci&oacute;n', 'text');
    $campo_desc->add_class('ui-icono-derecha');
    $campo_desc->set_required();

    $campo_res = new CampoTexto('resumen', '', $producto->getResumen());
    $campo_res->add_class('ui-icono-derecha');
    $campo_res->set_placeholder('Resumen del producto');
    $campo_res->set_required();

    $campo_pre = new CampoDecimal('precio', $producto->getPrecio(), 'Precio');
    $campo_pre->add_class('ui-icono-derecha');
    $campo_pre->set_required();

    $campos_cat = array();
    
    $categorias = new ListaCategorias();
    $lista_categorias = $categorias->getCategorias();
    
    $cats_prod = $producto->getCategorias();
    
    foreach ($lista_categorias as $cat) {
        $checked = FALSE;
        foreach ($cats_prod as $value) {
            if ($value['codigo'] == $cat->getCodigo()) {
                $checked = TRUE;
                break;
            }
        }
        $campos_cat[] = new CampoBooleano('categorias[]', $cat->getCodigo(), $cat->getDescripcion(), $checked);
    }
    
    $boton = new Boton('editar-producto', 'editar producto');
    $boton->add_class('ui-boton-naranja');

    $formulario->open();

    $campo_cod->show();
    
    $campo_desc->show();
    $campo_res->show();
    $campo_pre->show();
    
    print '<p>Categor&iacute;as:</p>';
    
    foreach ($campos_cat as $campo) {
        $campo->show();
    }
    
    print '<p>Im&aacute;genes:</p>';
    
    $imagenes = $producto->getImagenes();
    
    print getImagen($imagenes[0]['imagen'], 'img_view');
    
    $campo_img_1 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_1->show();
    
    print getImagen($imagenes[1]['imagen'], 'img_view');
    
    $campo_img_2 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_2->show();
    
    print getImagen($imagenes[2]['imagen'], 'img_view');
    
    $campo_img_3 = new Campo('imagenes[]', '', '', 'file');
    $campo_img_3->show();

    $boton->show();

    $formulario->close();
?>