<?php
/*
    lista_mensajes.php
    
    Implementa un lista de mensajes
*/
/* 
    Created on : 26/04/2015, 12:57:32
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class ListaMensajes {
    
    private $mensajes;
    private $filtro;
    private $orden;
    private $puntero;

    public function __construct() {
        $this->mensajes = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroDe($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " de = ".$usuario;
    }
    
    public function setFiltroPara($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " para = ".$usuario;
    }
    
    public function setFiltroLeidos($leido = FALSE) {
        $this->verificarFiltro();
        if ($leido) {
            $this->filtro .= " leido = 1";
        }
        else {
            $this->filtro .= " leido = 0";
        }
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM mensajes";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($query))) {
            while ($row = mysql_fetch_array($result)) {
                $this->mensajes[] = new Mensajes($row[0]);
            }
        }
    }
    
    public function getMensajes() {
        return $this->mensajes;
    }
    
    public function getCantidad() {
        return sizeof($this->mensajes);
    }
    
    public function getSiguienteOperacion() {
        $operacion = $this->mensajes[$this->puntero++];
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