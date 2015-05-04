<?php
/*
    ver_usuario.php
    
    Descripcion del archivo ver_usuario
*/
/* 
    Created on : 28/04/2015, 17:50:54
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/imagen.php');
    include_once('inc/usuarios.php');
    include_once('inc/zonas.php');
    include_once('inc/puntaje_usuario.php');
    include_once('inc/publicaciones.php');
    include_once('inc/lista_publicaciones.php');
    include_once('inc/productos.php');
    include_once('inc/lista_productos.php');
    include_once('inc/categorias.php');
    include_once('inc/lista_categorias.php');
    include_once('inc/denuncias.php');
    include_once('inc/lista_denuncias.php');
    include_once('inc/operaciones.php');
    include_once('inc/lista_operaciones.php');
    
    $usuario = new Usuarios($_REQUEST['codigo']);
    
    $zona = new Zonas($usuario->getZona());
    
    $puntaje = new PuntajeUsuario($usuario->getCodigo());
    
    $denuncias = new ListaDenuncias();
    $denuncias->setFiltroUsuario($usuario->getCodigo());
    $denuncias->cargarDenuncias();
    
    $publicaciones = new ListaPublicaciones();
    $publicaciones->setFiltroUsuario($usuario->getCodigo());
    $publicaciones->cargarLista();
    
    $numero_publicaciones = $publicaciones->getCantidad();
    
    $productos = new ListaProductos();
    $productos->setFiltroUsuario($usuario->getCodigo());
    $productos->cargarLista();
    
    $numero_productos = $productos->getCantidad();
    
    $operaciones = new ListaOperaciones();
    $operaciones->setFiltroConcretadas();
    $operaciones->setFiltroComprador($usuario->getCodigo());
    $operaciones->cargarLista();
    
    $numero_operaciones = $operaciones->getCantidad();
    
    $operaciones->borrarFiltro();
    $operaciones->setFiltroConcretadas();
    $operaciones->setFiltroVendedor($usuario->getCodigo());
    $operaciones->cargarLista();
    
    $numero_operaciones += $operaciones->getCantidad();
?>
    
<h1>Ficha personal de <?php print $usuario->getApodo(); ?></h1>

<p><?php print $usuario->getResumen(); ?></p>

<?php
    $imagen = new Imagen($usuario->getImagen());
    $imagen->set_class('img_view');
    $imagen->show();
?>

<p>&nbsp;</p>

<p>Ingres&oacute; a Mercado Social hace <?php print getTiempoPasado($usuario->getAlta()); ?></p>
    
<p>Vive en la zona de <?php print $zona->getZona(); ?></p>

<p>&nbsp;</p>
    
<p><span class="ui-icono ui-icono-estrella"></span>El puntaje dado por otros usuarios de Mercado Social es de <?php print $puntaje->calcular(); ?>
    
    <div class="grafica_barra grafica_barra_chico">
        <?php
            $valor_puntaje = floor($puntaje->calcular());

            for ($index = 0; $index < $valor_puntaje; $index++) {
                print '<div class="grafica_unidad_barra"></div>';
                print '<div class="grafica_unidad_barra"></div>';
            }
        ?>
    </div>

    <?php print $puntaje->calcular().' de 5.0'; ?>
</p>

    <?php print 'Puntaje '.round($puntaje->calcular()/5*100).'% positivo'; ?>

<p>&nbsp;</p>

<?php 
    if ($denuncias->getCantidad() > 0) {
        print '<p><span class="ui-icono ui-icono-atencion"></span>Tiene actualmente '.$denuncias->getCantidad().' denuncias en su contra</p>';
    }
    else {
        print '<p>No tiene denuncias en su contra</p>';
    }
?>

<p>&nbsp;</p>

<p><span class="ui-icono ui-icono-feliz"></span>Tiene <?php print $numero_publicaciones; ?> publicaciones activas</p>

<p><span class="ui-icono ui-icono-pastel"></span>Tiene <?php print $numero_productos; ?> productos en su tienda</p>

<p><span class="ui-icono ui-icono-engranaje"></span>Ha realizado <?php print $numero_operaciones; ?> operaciones en el sitio</p>

<p>&nbsp;</p>

<p>Detalle de los productos de <?php print $usuario->getApodo(); ?>:</p>

<div class="grafica">

    <ul>
        <?php
            $categorias = new ListaCategorias();

            foreach ($categorias->getCategorias() as $categoria) {
                $productos = new ListaProductos();
                $productos->setFiltroCategorias($categoria->getCodigo(), $usuario->getCodigo());
                $productos->cargarLista();

                print '<li><span>'.$categoria->getDescripcion().'</span>';

                print '<div class="grafica_barra">';

                $porcentaje = round($productos->getCantidad() / $numero_productos * 10);

                for ($index = 0; $index < $porcentaje; $index++) {
                    print '<div class="grafica_unidad_barra"></div>';
                }

                print '</div>';
                
                if ($productos->getCantidad()) {
                    print '&nbsp;'.$productos->getCantidad();
                }

                print '</li>';
            }
        ?>
    </ul>
    
</div>

<p>&nbsp;</p>

<?php
    $en_tienda = new Enlace('ver-tienda', 'Ver publicaciones', '?include=publicacion&usuario='.$usuario->getCodigo());
    $en_tienda->add_class('ui-boton ui-boton-naranja');
    $en_tienda->show();
?>