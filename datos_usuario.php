<?php
/*
    datos_usuario.php
    
    Permite visualizar los datos de usuario durante una operacion
*/
/* 
    Created on : 01/05/2015, 16:06:47
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
    include_once('inc/alerta.php');
    include_once('inc/enlace.php');
    include_once('lib/nusoap.php');
    include_once('inc/enlace_mapa.php');
    include_once('inc/usuarios.php');
    include_once('inc/zonas.php');
    include_once('inc/puntaje_usuario.php');
    include_once('inc/denuncias.php');
    include_once('inc/lista_denuncias.php');
    include_once('inc/operaciones.php');
    include_once('inc/publicaciones.php');
    include_once('inc/lista_publicaciones.php');
    
    if(!validRequest('operacion')) {
        $alerta = new Alerta('alerta', 'NO SE ENCUENTRA UNA OPERACION VALIDA');
    }
    else {
        $operacion = new Operaciones($_REQUEST['operacion']);
        $publicacion = new Publicaciones($operacion->getPublicacion());
        
        if(is_null($publicacion->getProducto())) {
            $alerta = new Alerta('alerta', 'NO SE ENCUENTRA UNA PUBLICACION VALIDA');
        }
    }
    
    $usuario = new Usuarios($_REQUEST['codigo']);
?>

<h1>Datos de contacto para <?php print $usuario->getApodo(); ?></h1>

<p>&nbsp;</p>

<?php 
    if (isset($alerta)) {
        
        print '<h2>La publicaci&oacute;n indicada ya no existe</h2>';
        print '<p>&nbsp;</p>';
        print '<p>Env&iacute;ele un mensaje al usuario para establecer el contacto</p>';
        
    }
    else {
        
        $puntaje = new PuntajeUsuario($usuario->getCodigo());
        
        print '<p>Puntaje '.$puntaje->calcular().' de 5.0</p>';
        
        $denuncias = new ListaDenuncias();
        $denuncias->setFiltroUsuario($usuario->getCodigo());
        $denuncias->cargarDenuncias();
        
        if ($denuncias->getCantidad() > 0) {
            print '<p><span class="ui-icono ui-icono-atencion"></span>Tiene actualmente '.$denuncias->getCantidad().' denuncias en su contra</p>';
        }
        else {
            print '<p>No tiene denuncias en su contra</p>';
        }
        
        print '<p>&nbsp;</p>';
        
        print '<h2><span class="ui-icono ui-icono-usuario"></span>'.$usuario->getNombre().' '.$usuario->getApellido().'</h2>';
        
        print '<p><span class="ui-icono ui-icono-sobre"></span>'.$usuario->getCorreo().'</p>';
        print '<p><span class="ui-icono ui-icono-casa"></span>'.$usuario->getDomicilio();
        
        $domicilio = separarDireccion($usuario->getDomicilio());
        
        $en_domicilio = new EnlaceMapa($domicilio['calle'], $domicilio['altura']);
        $en_domicilio->show();
        
        print '</p>';
        
        $zona = new Zonas($usuario->getZona());
        
        print '<p><span class="ui-icono ui-icono-lugar"></span>Barrio '.$zona->getZona().'</p>';
        
        print '<p><span class="ui-icono ui-icono-telefono"></span>'.$usuario->getTelefono().'</p>';
        
    }
    
    print '<p>&nbsp;</p>';
    
    $en_contacto = new Enlace('contacto', 'Enviar mensaje', '?include=usuario&form=escribir_mensaje&codigo='.$usuario->getCodigo());
    $en_contacto->add_class('ui-boton ui-boton-verde');
    $en_contacto->show();
?>