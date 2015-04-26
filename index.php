<?php
/*
    index.php
    
    Archivo indice del sitio
    Estructura basica y carga de informacion
*/
/* 
    Created on : 15/04/2015, 15:16:42
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

    include_once("inc/util.php");
    include_once("inc/alerta.php");
    include_once("inc/conexion.php");
    include_once("inc/sesion.php");
    include_once("inc/usuarios.php");
    
    $alerta = NULL;
    
    $formulario = NULL;
    
    if (validRequest('form')) {
        $formulario = $_REQUEST['form'];
    }
    
    $include = NULL;
    
    if (validRequest('include')) {
        $include = $_REQUEST['include'];
    }
    
    $conexion = new Conexion();
    
    if (!$conexion->conectar()) {
        header('Location: ./');
    }
    
    $sesion = new Sesion();
    
    $usuario = NULL;
    
    if ($sesion->is_logged()) {
        if (isLogout()) {
            $sesion->logout();
            header('location: index.php');
        }
        
        $usuario = new Usuarios($sesion->get_user_id());
        
        if (isset($_REQUEST['editar-usuario'])) {
            include_once('inc/editar_usuario.php');
        }
        elseif (isset($_REQUEST['agregar-producto'])) {
            include_once('inc/agregar_producto.php');
        }
        elseif (isset($_REQUEST['editar-producto'])) {
            include_once('inc/editar_producto.php');
        }
        elseif (isset($_REQUEST['publicar-producto'])) {
            include_once('inc/publicar_producto.php');
        }
        elseif (isset($_REQUEST['cancelar-publicacion'])) {
            include_once('inc/cancelar_publicacion.php');
        }
        elseif (isset($_REQUEST['realizar-pregunta'])) {
            include_once('inc/preguntar.php');
        }
        elseif (isset($_REQUEST['enviar-respuesta'])) {
            include_once('inc/responder.php');
        }
    }
    else {
        if (isLogin()) {
            if (!$sesion->login()) {
                $alerta = new Alerta('alerta', 'VERIFIQUE SU NOMBRE DE USUARIO Y CONTRASE&Ntilde;A');
            }
            header('location: index.php');
        }
        else{
            if (isset($_REQUEST['registrarse'])) {
                include_once('inc/registrar.php');
                if (is_null($alerta)) {
                    $formulario = 'bienvenida';
                }
            }
        }
    }
    
    $sesion->iniciar();

?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>Mercado Social MDQ</title>
        <meta name="generator" content="Netbeans IDE 8.0.2 (2015)">
        <meta name="author" content="Juan Manuel Scarciofolo">
        <meta name="keywords" content="mercado, social, mar del plata, economia, intercambio, ventas, productos, organico, reciclado, propio">
        <meta name="description" content="Mercado virtual destinado al fomento de las economias sociales emergentes">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="principal.js"></script>
        <link href="estilo.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="contenedor">
            
            <?php include_once("encabezado.php"); ?>
            
            <div id="barra_mensajes">
                <?php
                    if (!is_null($alerta)) {
                        print $alerta->mostrar();
                    }
                ?>
            </div>
            
            <?php
                if (isset($include) || !isset($formulario)) {
                    include_once("lateral_izq.php");
                    include_once("principal.php");
                }
                else {
                    include_once($formulario.'.php');
                }
            ?>
            <?php //include_once("lateral_der.php"); ?>
            <?php //include_once("pie.php"); ?>
        </div>
    </body>
</html>