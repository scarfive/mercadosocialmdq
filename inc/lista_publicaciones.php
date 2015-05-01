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
    private $limite;
    private $cantidad;

    public function __construct() {
        $this->publicaciones = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->limite = NULL;
        $this->cantidad = NULL;
    }
    
    public function setFiltroCategoria($categoria) {
        $this->filtro = " WHERE producto IN (SELECT producto FROM cat_productos WHERE categoria = ".$categoria.")";
    }
    
    public function setFiltroUsuario($usuario) {
        $this->filtro = " WHERE producto IN (SELECT codigo FROM productos WHERE usuario = ".$usuario.")";
    }
    
    public function novedades() {
        $this->setOrdenFecha('DESC');
        $this->setLimite(0);
        $this->setCantidad(20);
    }
    
    public function loMasVisto() {
        $this->setOrdenVistas('DESC');
        $this->setLimite(0);
        $this->setCantidad(20);
    }
    
    public function busquedaPorDescripcion($busqueda) {
        $this->filtro = " WHERE producto IN (SELECT codigo FROM productos WHERE descripcion LIKE '%".$busqueda."%')";
    }
    
    public function setOrdenPrecio($dir = 'ASC') {
        $this->orden = " ORDER BY precio ".$dir;
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function setOrdenVistas($dir = 'ASC') {
        $this->orden = " ORDER BY vistas ".$dir;
    }
    
    public function setLimite($limite) {
        $this->limite = $limite;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
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
        if (!empty($this->limite) && !empty($this->cantidad)) {
            $query .= " LIMIT ".$this->limite.", ".$this->cantidad;
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