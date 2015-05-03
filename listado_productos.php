<?php
/*
    listado_productos.php
    
    Lista de productos de un usuario determinado
*/
/* 
    Created on : 19/04/2015, 22:53:50
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/enlace.php');
    include_once('inc/categorias.php');
    include_once('inc/productos.php');
    include_once('inc/productos_usuario.php');
    
    $productos = new ProductosUsuario($usuario->getCodigo());
    
    $arr_productos = $productos->getProductos();
?>

<h1>Productos guardados</h1>

<div class="barra_opciones">
    <?php
        $en_agregar = new Enlace('agregar', 'Agregar producto', '?include=usuario&form=agregar');
        $en_agregar->add_class('ui-boton ui-boton-azul');
        $en_agregar->show();
    ?>
</div>

<table class="listado">
    
    <?php
        if (empty($arr_productos)) {
            print '<h1>Todav&iacute;a no tiene productos guardados</h1>';
            print '<p>&nbsp;</p>';
            print '<p>Haga click en <i><b><a href="?include=usuario&form=agregar">agregar producto</a></b></i> para comenzar a guardar los productos que quiera vender.</p>';
            print '<p>Luego podr&aacute; verlos en esta secci&oacute;n y modificarlos.</p>';
            print '<p>Tambi&eacute;n necesita guardar productos para poder publicarlos.</p>';
        }
        else {
            $par = 0;
            
            foreach ($arr_productos as $producto) {
                
                $publicacion = NULL;
                
                $publicado = $producto->is_published();
                
                if($publicado) {
                    $publicacion = new Publicaciones($producto->getPublicacion());
                }
                
                $img = $producto->getImagenes();
                
                print '<tr class="';
                if ($par % 2) {
                    print 'fila_impar';
                }
                else {
                    print 'fila_par';
                }
                print '">';
                
                print '<td class="celda_imagen">'.getImagen($img[0]['imagen'], 'img_preview').'</td>';
                
                print '<td class="celda_titulo">'.$producto->getDescripcion().'</td>';
                
                print '<td class="celda_info">';
                
                if ($publicado) {
                    $en_vistas = new Enlace('vistas', $publicacion->getVistas().' vistas', '?include=publicacion&form=datos_producto&codigo='.$producto->getCodigo());
                    $en_vistas->add_class('ui-enlace-icono ui-icono-vista');
                    $en_vistas->show();
                }
                
                $en_calif = new Enlace('calificacion', redondeo($producto->getCalificacion()).' de 5 puntos', '?include=publicacion&form=datos_producto&codigo='.$producto->getCodigo());
                $en_calif->add_class('ui-enlace-icono ui-icono-estrella');
                $en_calif->show();

                $en_comen = new Enlace('comentarios', $producto->getComentarios().' comentarios', '?include=publicacion&form=datos_producto&codigo='.$producto->getCodigo());
                $en_comen->add_class('ui-enlace-icono ui-icono-mensaje');
                $en_comen->show();
                
                print '</td>';
                
                $categorias = '';
                
                foreach ($producto->getCategorias() as $cat) {
                    $categorias .= $cat['descripcion'].'<br>';
                }
                
                print '<td class="celda_categorias">'.quitarUltimoCaracter($categorias).'</td>';
                
                print '<td class="celda_opciones">';
                
                if (!$publicado) {
                
                    $enl_editar = new Enlace('editar', 'Editar', '?include=usuario&form=edicion_producto&codigo='.$producto->getCodigo());
                    $enl_editar->add_class('ui-enlace-icono ui-icono-lapiz');
                    $enl_editar->show();

                    $enl_publicar = new Enlace('publicar', 'Publicar', '?include=usuario&form=publicacion_producto&codigo='.$producto->getCodigo());
                    $enl_publicar->add_class('ui-enlace-icono ui-icono-feliz');
                    $enl_publicar->show();

                    $enl_borrar = new Enlace('borrar', 'Borrar', '?include=usuario&form=borrar_producto&codigo='.$producto->getCodigo());
                    $enl_borrar->add_class('ui-enlace-icono ui-icono-cruz');
                    $enl_borrar->show();
                
                }
                else {
                    
                    $enl_pub = new Enlace('ver', 'Publicado', '?include=usuario&form=ver_publicacion&codigo='.$publicacion->getCodigo());
                    $enl_pub->add_class('ui-enlace-icono ui-icono-candado');
                    $enl_pub->show();
                    
                }
                
                print '</td>';
                
                print '</tr>';
                
                $par++;
            }
        }
    ?>
    
</table>