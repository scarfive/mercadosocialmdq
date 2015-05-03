<?php
/*
    lista_preguntas.php
    
    Implementa una lista de preguntas de publicaciones
*/
/* 
    Created on : 25/04/2015, 03:23:21
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaPreguntas {
    
    private $preguntas;
    private $filtro;
    private $orden;
    private $inicio;
    private $cantidad;

    public function __construct() {
        $this->preguntas = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->inicio = NULL;
        $this->cantidad = NULL;
    }
    
    public function setFiltroRespondidas($respondidas = FALSE) {
        $this->verificarFiltro();
        if ($respondidas) {
            $this->filtro .= " respondida = 1";
        }
        else {
            $this->filtro .= " respondida = 0";
        }
    }
    
    public function setFiltroPublicacion($publicacion) {
        $this->verificarFiltro();
        $this->filtro .= " publicacion = ".$publicacion;
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " publicacion IN (SELECT publicaciones.codigo FROM publicaciones, productos WHERE publicaciones.producto = productos.codigo AND productos.usuario = ".$usuario.")";
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
        $query = "SELECT codigo FROM preguntas";
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
                $this->preguntas[] = new Preguntas($row[0]);
            }
        }
    }
    
    public function getPreguntas() {
        return $this->preguntas;
    }
    
    public function getCantidad() {
        return sizeof($this->preguntas);
    }
    
    public function getTotal() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM preguntas";
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