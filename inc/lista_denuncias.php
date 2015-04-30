<?php
/*
    lista_denuncias.php
    
    lista_denuncias
*/
/* 
    Created on : 30/04/2015, 18:10:02
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaDenuncias {
    
    private $denuncias;
    private $filtro;
    private $orden;
    private $puntero;

    public function __construct() {
        $this->denuncias = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " usuario = ".$usuario;
    }
    
    public function setOrdenCodigo($dir = 'ASC') {
        $this->orden = " ORDER BY codigo ".$dir;
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function cargarDenuncias() {
        $conn = new Conexion();
        $conn->conectar();
        $select = "SELECT codigo FROM denuncias";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($select))) {
            while ($row = mysql_fetch_array($result)) {
                $this->denuncias[] = new Denuncias($row[0]);
            }
        }
    }
    
    public function getDenuncias() {
        return $this->denuncias;
    }
    
    public function getCantidad() {
        return sizeof($this->denuncias);
    }
    
    public function getSiguienteDenuncia() {
        if ($this->puntero >= $this->getCantidad()) {
            return NULL;
        }
        $operacion = $this->productos[$this->puntero++];
        return $operacion;
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