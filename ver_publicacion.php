<?php
/*
    ver_publicacion.php
    
    Permite visualizar una publicacion y muestra opciones sobre ella
*/
/* 
    Created on : 23/04/2015, 01:54:23
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/enlace.php');
    include_once('inc/publicaciones.php');
    include_once('inc/productos.php');
    include_once('inc/usuarios.php');
    
    $publicacion = new Publicaciones($_REQUEST['codigo']);
    $producto = new Productos($publicacion->getProducto());
    $usuario = new Usuarios($producto->getUsuario());
    
    $es_propietario = FALSE;
    
    if ($producto->getUsuario() == $sesion->get_user_id()) {
        $es_propietario = TRUE;
    }
?>

<div class="publicacion">

    <p class="publicacion_info">Finaliza en <?php print fechaRelativa($publicacion->getLimite()); ?> d&iacute;as</p>
    
    <h1><?php print $producto->getDescripcion(); ?></h1>
    
    <?php 
        $en_vistas = new Enlace('vistas', $publicacion->getVistas().' vistas', '?include=usuario&form=ver_vistas&codigo='.$publicacion->getCodigo());
        $en_vistas->add_class('ui-enlace-icono ui-icono-vista');
        

        $en_calif = new Enlace('calificacion', redondeo($producto->getCalificacion()).' de 5 puntos', '?include=usuario&form=ver_calificaciones&codigo='.$producto->getCodigo());
        $en_calif->add_class('ui-enlace-icono ui-icono-estrella');

        $en_comen = new Enlace('comentarios', $producto->getComentarios().' comentarios', '?include=usuario&form=ver_comentarios&codigo='.$publicacion->getCodigo());
        $en_comen->add_class('ui-enlace-icono ui-icono-mensaje');

        $en_usuario = new Enlace('usuario', 'Publicado por '.$usuario->getApodo(), '?include=publicacion&form=ver_usuario&codigo='.$usuario->getCodigo());
        $en_usuario->add_class('ui-enlace-icono ui-icono-usuario');
    ?>
    
    <div class="publicacion_detalles">
        <ul>
            <li><?php $en_vistas->show(); ?></li>
            <li><?php $en_calif->show(); ?></li>
            <li><?php $en_comen->show(); ?></li>
            <li><?php $en_usuario->show(); ?></li>
        </ul>
    </div>
    
    <?php
        $imagenes = $producto->getImagenes();
        
        for ($index = 0; $index < sizeof($imagenes); $index++) {
            if (!empty($imagenes[$index]['imagen'])) {
                print getImagen($imagenes[$index]['imagen'], 'img_view');
            }
        }
    ?>

    <p><?php print textoHTML($producto->getResumen()); ?></p>
    
    <div class="publicacion_precio">
        <p class="precio"><?php print mostrarPrecio($publicacion->getPrecio()); ?></p>
        
        <p class="precio_pie">precio final</p>
    </div>
    
</div>

<?php
    if ($es_propietario) {
        $en_cancelar = new Enlace('cancelar', 'Cancelar publicaci&oacute;n', '?include=usuario&form=publicacion_detener&codigo='.$_REQUEST['codigo']);
        $en_cancelar->add_class('ui-boton ui-boton-naranja');
        $en_cancelar->show();
    }
    else {
        $en_comprar = new Enlace('comprar', 'Comprar producto', '?include=usuario&form=compra_confirmacion&codigo='.$_REQUEST['codigo']);
        $en_comprar->add_class('ui-boton ui-boton-azul');
        $en_comprar->show();

        $en_preguntar = new Enlace('preguntar', 'Hacer una pregunta', '?include=usuario&form=realizar_pregunta&codigo='.$_REQUEST['codigo']);
        $en_preguntar->add_class('ui-boton ui-boton-naranja');
        $en_preguntar->show();
    }
?>

<?php
    if (!$es_propietario) {
        $publicacion->sumarVista();
    }
?>