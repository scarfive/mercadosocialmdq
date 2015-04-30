<?php
/*
    util.php
    
    Funciones de utilidad para el sistema
*/
/* 
    Created on : 18/04/2015, 19:14:43
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

function validRequest($name) {
    if (!isset($_REQUEST[$name]) || empty($_REQUEST[$name])) {
        return FALSE;
    }
    return TRUE;
}

function isLogout() {
    if (isset($_REQUEST['salir']) && $_REQUEST['salir'] == 'salir') {
        return TRUE;
    }
    return FALSE;
}

function isLogin() {
    if (isset($_REQUEST['ingresar']) && isset($_REQUEST['u']) && isset($_REQUEST['p'])) {
        return TRUE;
    }
    return FALSE;
}

function getImagen($src, $class) {
    if (!empty($src) && file_exists($src)) {
        return '<img src="'.$src.'" class="'.$class.'" alt="" />';
    }
    return '<img src="img/sin-imagen.png" class="'.$class.'" alt="" />';
}

function quitarUltimoCaracter($str) {
    return substr($str, 0, strlen($str) - 1);
}

function mostrarPrecio($precio) {
    return number_format($precio, 2);
}

function getRandomId() {
    $number = time() + rand();
    return substr($number, 0, 10);
}

function textoSQL($str) {
    return htmlspecialchars(addslashes($str));
}

function textoHTML($str) {
    return nl2br(stripslashes(htmlspecialchars_decode($str)));
}

function extractoTexto($str) {
    return substr($str, 0, 256).'...';
}

function extractoDescripcion($str) {
    $max_len = 19;
    if (strlen($str) > $max_len) {
        return substr($str, 0, $max_len).'...';
    }
    return $str;
}

function sqlDateFormat() {
    return 'Y-m-d H:i:s';
}

function htmlDateFormat($date) {
    return date('d/m/Y', strtotime($date)) ;
}

function redondeo($numero) {
    return round($numero, 1);
}

function fechaRelativa($fecha) {
    $day = 24*60*60;
    $today = time();
    $date = strtotime($fecha);
    return round(($date - $today)/$day);
}

function getTiempoPasado($fecha) {
    $tiempo = 0;
    $cadena = '';
    if (($tiempo = sonAnios($fecha))) {
        $cadena = 'a&ntilde;o';
    }
    elseif (($tiempo = sonMeses($fecha))) {
        $cadena = 'mes';
    }
    elseif (($tiempo = sonDias($fecha))) {
        $cadena = 'd&iacute;a';
    }
    elseif (($tiempo = sonHoras($fecha))) {
        $cadena = 'hora';
    }
    elseif (($tiempo = sonMinutos($fecha))) {
        $cadena = 'minuto';
    }
    else {
        $tiempo = cantidadSegundos($fecha);
        $cadena = 'segundo';
    }
    if ($tiempo < 2) {
        $cadena = 'un'.genero($cadena).' '.$cadena;
    }
    else {
        $cadena = $tiempo.' '.plural($cadena);
    }
    return $cadena;
}

function cantidadSegundos($fecha) {
    return fechaEnIntervalo($fecha, 1);
}

function sonMinutos($fecha) {
    $minuto = 60;
    return fechaEnIntervalo($fecha, $minuto);
}

function sonHoras($fecha) {
    $hora = 60*60;
    return fechaEnIntervalo($fecha, $hora);
}

function sonDias($fecha) {
    $dia = 24*60*60;
    return fechaEnIntervalo($fecha, $dia);
}

function sonMeses($fecha) {
    $mes = 30*24*60*60;
    return fechaEnIntervalo($fecha, $mes);
}

function sonAnios($fecha) {
    $anio = 365*24*60*60;
    return fechaEnIntervalo($fecha, $anio);
}

function fechaEnIntervalo($fecha, $intervalo) {
    $today = time();
    $date = strtotime($fecha);
    $result = floor(($today - $date)/$intervalo);
    if ($result < 1) {
        return FALSE;
    }
    return $result;
}

function plural($str) {
    $vocales = array('a', 'e', 'i', 'o', 'u');
    $ultima_letra = substr($str, -1);
    if (in_array($ultima_letra, $vocales)) {
        return $str.'s';
    }
    return $str.'es';
}

function genero($str) {
    /*$ultima_letra = substr($str, -1);
    if ($ultima_letra == 'a') {*/
    if ($str == 'hora') {
        return 'a';
    }
    return NULL;
}

function quitarTildes($str) {
    $car_especiales = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $car_normales = array("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    return str_replace($car_especiales, $car_normales, $str);
}

function extraerNombre($str) {
    return strtolower(quitarTildes($str));
}

?>