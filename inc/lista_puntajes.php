<?php
/*
    lista_puntajes.php
    
    Implementa una lista de puntajes
*/
/* 
    Created on : 01/05/2015, 22:03:19
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaPuntajes {
    
    private $puntajes;
    private $filtro;
    private $orden;
    private $inicio;
    private $cantidad;
    private $puntero;

    public function __construct() {
        $this->puntajes = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->inicio = NULL;
        $this->cantidad = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroOperacion($operacion) {
        $this->verificarFiltro();
        $this->filtro .= " operacion = ".$operacion;
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " para = ".$usuario;
    }
    
    public function setOrdenFecha($dir = 'DESC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function setOrdenCodigo($dir = 'DESC') {
        $this->orden = " ORDER BY codigo ".$dir;
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
        $query = "SELECT codigo FROM puntajes";
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
                $this->puntajes[] = new Puntajes($row[0]);
            }
        }
    }
    
    public function getPuntajes() {
        return $this->puntajes;
    }
    
    public function getCantidad() {
        return sizeof($this->puntajes);
    }
    
    public function getTotal() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM puntajes";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if ($conn->ejecutar($query)) {
            return $conn->registros();
        }
        return FALSE;
    }
    
    public function getSiguientePuntaje() {
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