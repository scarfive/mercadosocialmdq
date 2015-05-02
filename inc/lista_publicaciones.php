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
    private $inicio;
    private $cantidad;

    public function __construct() {
        $this->publicaciones = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->inicio = NULL;
        $this->cantidad = NULL;
    }
    
    public function setFiltroCategoria($categoria) {
        $this->verificarFiltro();
        $this->filtro .= " producto IN (SELECT producto FROM cat_productos WHERE categoria = ".$categoria.")";
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " producto IN (SELECT codigo FROM productos WHERE usuario = ".$usuario.")";
    }
    
    public function setFiltroActivas($activa = 1) {
        $this->verificarFiltro();
        $this->filtro .= " activa = ".$activa;
    }
    
    public function novedades() {
        $this->setOrdenFecha('DESC');
    }
    
    public function loMasVisto() {
        $this->setOrdenVistas('DESC');
    }
    
    public function busquedaPorDescripcion($busqueda) {
        $this->verificarFiltro();
        $this->filtro ." producto IN (SELECT codigo FROM productos WHERE descripcion LIKE '%".$busqueda."%')";
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
    
    public function setInicio($inicio) {
        $this->inicio = $inicio;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM publicaciones";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!is_null($this->orden)) {
            $query .= $this->orden;
        }
        if (!is_null($this->inicio) && !is_null($this->cantidad)) {
            $query .= " LIMIT ".$this->inicio.", ".$this->cantidad;
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
    
    public function getTotal() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM publicaciones";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if ($conn->ejecutar($query)) {
            return $conn->registros();
        }
        return FALSE;
    }
    
    private function verificarFiltro() {
        if (empty($this->filtro)) {
            $this->filtro = ' WHERE ';
        }
        else {
            $this->filtro .= ' AND ';
        }
    }
    
}
?>