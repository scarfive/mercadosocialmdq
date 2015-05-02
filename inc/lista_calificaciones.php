<?php
/*
    lista_calificaciones.php
    
    Implementa una lista de calificaciones
*/
/* 
    Created on : 01/05/2015, 21:27:24
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaCalificaciones {
    
    private $calificaciones;
    private $filtro;
    private $orden;
    private $puntero;

    public function __construct() {
        $this->calificaciones = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroProducto($producto) {
        $this->verificarFiltro();
        $this->filtro .= " producto = ".$producto;
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " producto IN (SELECT codigo FROM productos WHERE usuario = ".$usuario.")";
    }
    
    public function setOrdenFecha($dir = 'DESC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function setOrdenCodigo($dir = 'DESC') {
        $this->orden = " ORDER BY codigo ".$dir;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM calificaciones";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($query))) {
            while ($row = mysql_fetch_array($result)) {
                $this->calificaciones[] = new Calificaciones($row[0]);
            }
        }
    }
    
    public function getCalificaciones() {
        return $this->calificaciones;
    }
    
    public function getCantidad() {
        return sizeof($this->calificaciones);
    }
    
    public function getSiguienteCalificacion() {
        if ($this->puntero >= $this->getCantidad()) {
            return FALSE;
        }
        return $this->mensajes[$this->puntero++];
    }
    
    public function resetPuntero() {
        return $this->puntero = 0;
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