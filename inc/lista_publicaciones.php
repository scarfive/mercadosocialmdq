<?php
/*
    lista_publicaciones.php
    
    Implementacion de una lista de publicaciones
*/
/* 
    Created on : 23/04/2015, 23:20:04
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaPublicaciones {
    
    private $publicaciones;
    private $filtro;
    private $orden;

    public function __construct() {
        $this->publicaciones = array();
        $this->filtro = NULL;
        $this->orden = NULL;
    }
    
    public function setFiltroCategoria($categoria) {
        $this->filtro = " WHERE producto IN (SELECT producto FROM cat_productos WHERE categoria = ".$categoria.")";
    }
    
    public function setFiltroUsuario($usuario) {
        $this->filtro = " WHERE producto IN (SELECT producto FROM productos WHERE usuario = ".$usuario.")";
    }
    
    public function setOrdenPrecio($dir = 'ASC') {
        $this->orden = " ORDER BY precio ".$dir;
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM publicaciones";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($query))) {
            while ($row = mysql_fetch_array($result)) {
                $this->publicaciones[] = new Publicaciones($row[0]);
            }
        }
    }
    
    public function getPublicaciones() {
        return $this->publicaciones;
    }
    
    public function getCantidad() {
        return sizeof($this->publicaciones);
    }
    
}
?>