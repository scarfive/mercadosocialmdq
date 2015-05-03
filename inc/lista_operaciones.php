<?php
/*
    lista_operaciones.php
    
    Implementa una lista de operaciones
*/
/* 
    Created on : 26/04/2015, 01:28:21
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaOperaciones {
    
    private $operaciones;
    private $filtro;
    private $orden;
    private $inicio;
    private $cantidad;
    private $puntero;

    public function __construct() {
        $this->operaciones = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->inicio = NULL;
        $this->cantidad = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroComprador($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " comprador = ".$usuario;
    }
    
    public function setFiltroVendedor($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " comprador != ".$usuario." AND publicacion IN (SELECT publicaciones.codigo FROM publicaciones, productos WHERE publicaciones.producto = productos.codigo AND productos.usuario = ".$usuario.")";
    }
    
    public function setFiltroConcretadas($concretada = FALSE) {
        $this->verificarFiltro();
        if ($concretada) {
            $this->filtro .= " concretada = 1";
        }
        else {
            $this->filtro .= " concretada = 0";
        }
    }
    
    public function borrarFiltro() {
        $this->filtro = NULL;
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
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
        $query = "SELECT codigo FROM operaciones";
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
                $this->operaciones[] = new Operaciones($row[0]);
            }
        }
    }
    
    public function getOperaciones() {
        return $this->operaciones;
    }
    
    public function getCantidad() {
        return sizeof($this->operaciones);
    }
    
    public function getTotal() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM operaciones";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if ($conn->ejecutar($query)) {
            return $conn->registros();
        }
        return FALSE;
    }
    
    public function getSiguienteOperacion() {
        $operacion = $this->operaciones[$this->puntero++];
        if ($this->puntero >= $this->getCantidad()) {
            $this->puntero = 0;
        }
        return $operacion;
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