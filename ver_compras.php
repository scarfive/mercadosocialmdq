<?php
/*
    ver_compras.php
    
    Permite visualizar las compras realizadas
*/
/* 
    Created on : 26/04/2015, 01:16:12
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    include_once('inc/lista_operaciones.php');
    include_once('inc/paginador.php');
    
    $operaciones = new ListaOperaciones();
    
    if (!validRequest('cantidad')) {
        $operaciones->setFiltroConcretadas();
    }
    
    $operaciones->setFiltroComprador($sesion->get_user_id());
    
    if (validRequest('inicio')) {
        $operaciones->setInicio($_REQUEST['inicio']);
    }
    else {
        $operaciones->setInicio(0);
    }
    
    $operaciones->setCantidad($_ELEMENTOS_POR_PAGINA);
    
    $operaciones->cargarLista();
?>

<h1>Compras realizadas</h1>

<p>Aqu&iacute; puede ver y administrar los productos comprados recientemente:</p>

<?php 
    if ($operaciones->getCantidad() > 0) {
        
        foreach ($operaciones->getOperaciones() as $operacion) {

            $publicacion = new Publicaciones($operacion->getPublicacion());
            $producto = new Productos($publicacion->getProducto());
            $usuario = new Usuarios($producto->getUsuario());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?include=usuario&form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">De ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Comprado hace '.getTiempoPasado($operacion->getFecha()).'</p>';
            
            print '<p class="ayuda">Estas son las acciones que restan completar:</p>';

            $en_datos = new Enlace('datos', 'Datos del vendedor', '?include=usuario&form=datos_usuario&operacion='.$operacion->getCodigo().'&codigo='.$producto->getUsuario());
            $en_datos->add_class('ui-mini-boton ui-boton-azul');
            $en_datos->show();

            $en_contacto = new Enlace('contacto', 'Contactar al vendedor', '?include=usuario&form=escribir_mensaje&codigo='.$producto->getUsuario());
            $en_contacto->add_class('ui-mini-boton ui-boton-verde');
            $en_contacto->show();

            if (!validRequest('cantidad')) {
                
                $en_terminar = new Enlace('terminar', 'Compra finalizada', '?include=usuario&form=compra_terminar&codigo='.$operacion->getCodigo());
                $en_terminar->add_class('ui-mini-boton ui-boton-naranja');
                $en_terminar->show();

                $en_denuncia = new Enlace('denunciar', 'Denunciar', '?include=usuario&form=realizar_denuncia&operacion=true&codigo='.$operacion->getCodigo());
                $en_denuncia->add_class('ui-mini-boton ui-boton-azul');
                $en_denuncia->show();

            }
                
            print '</div>';
        }
        
        if (validRequest('cantidad')) {
            $paginador = new Paginador($_ELEMENTOS_POR_PAGINA, $operaciones->getTotal());
            $paginador->show();
        }
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene compras recientes</h1>';
        print '<p>&nbsp;</p>';
    }
    
    if (!validRequest('cantidad')) {
        $en_todas = new Enlace('compras-todas', 'Ver todas', '?include=usuario&form=ver_compras&cantidad=todas');
        $en_todas->add_class('ui-boton ui-boton-azul');
        $en_todas->show();
    }
?>