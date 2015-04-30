<?php
/*
    ver_ventas.php
    
    Permite visualizar las ventas de un usuario determinado
*/
/* 
    Created on : 28/04/2015, 17:10:44
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/usuarios.php');
    include_once('inc/productos.php');
    include_once('inc/publicaciones.php');
    include_once('inc/operaciones.php');
    include_once('inc/lista_operaciones.php');
    
    $operaciones = new ListaOperaciones();
    
    if (!validRequest('cantidad')) {
        $operaciones->setFiltroConcretadas();
    }
    
    $operaciones->setFiltroVendedor($sesion->get_user_id());
    $operaciones->cargarLista();
?>

<h1>Ventas realizadas</h1>

<p>Aqu&iacute; puede ver y administrar sus productos vendidos recientemente:</p>

<?php 
    if ($operaciones->getCantidad() > 0) {
        
        foreach ($operaciones->getOperaciones() as $operacion) {

            $publicacion = new Publicaciones($operacion->getPublicacion());
            $producto = new Productos($publicacion->getProducto());
            $usuario = new Usuarios($operacion->getComprador());

            $imagenes = $producto->getImagenes();

            print '<div class="cuadro_lista">';

            print '<img class="img_micro" src="'.$imagenes[0]['imagen'].'" />';

            print '<h2>'.$producto->getDescripcion().'</h2>';

            $en_usuario = new Enlace('ver-usuario', $usuario->getApodo(), '?include=usuario&form=ver_usuario&codigo='.$usuario->getCodigo());

            print '<p class="detalles">Comprado por ';
            $en_usuario->show();
            print '</p>';

            print '<p class="detalles">Vendido hace '.getTiempoPasado($operacion->getFecha()).'</p>';
            
            print '<p class="ayuda">Estas son las acciones que restan completar:</p>';

            $en_contacto = new Enlace('contacto', 'Contactar al comprador', '?include=usuario&form=escribir_mensaje&codigo='.$usuario->getCodigo());
            $en_contacto->add_class('ui-mini-boton ui-boton-naranja');
            $en_contacto->show();

            /*if (!validRequest('cantidad')) {
                
                $en_denuncia = new Enlace('denunciar', 'Denunciar', '?include=usuario&form=realizar_denuncia&codigo='.$operacion->getCodigo());
                $en_denuncia->add_class('ui-mini-boton ui-boton-naranja');
                $en_denuncia->show();

            }*/
            
            print '</div>';
        }
        
    }
    else {
        print '<p>&nbsp;</p>';
        print '<h1>No tiene ventas recientes</h1>';
        print '<p>&nbsp;</p>';
    }
    
    if (!validRequest('cantidad')) {
        $en_todas = new Enlace('compras-todas', 'Ver todas', '?include=usuario&form=ver_ventas&cantidad=todas');
        $en_todas->add_class('ui-boton ui-boton-verde');
        $en_todas->show();
    }
?>