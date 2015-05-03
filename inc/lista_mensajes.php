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
    private $inicio;
    private $cantidad;
    private $agrupacion;
    private $puntero;

    public function __construct() {
        $this->mensajes = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->inicio = NULL;
        $this->cantidad = NULL;
        $this->agrupacion = NULL;
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
    
    public function setFiltroEntre($usuario1, $usuario2) {
        $this->verificarFiltro();
        $this->filtro .= " (de = ".$usuario1." OR de = ".$usuario2.") AND (para = ".$usuario1." OR para = ".$usuario2.")";
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
    
    public function setOrdenUsuario($dir = 'ASC') {
        $this->orden = " ORDER BY de, codigo ".$dir;
    }
    
    public function setOrdenCodigo($dir = 'ASC') {
        $this->orden = " ORDER BY codigo ".$dir;
    }
    
    public function agruparPorRemitente() {
        $this->agrupacion = " GROUP BY de";
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
        $query = "SELECT codigo FROM mensajes";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!is_null($this->agrupacion)) {
            $query .= $this->agrupacion;
        }
        if (!is_null($this->orden)) {
            $query .= $this->orden;
        }
        if (!is_null($this->inicio) && !is_null($this->cantidad)) {
            $query .= " LIMIT ".$this->inicio.", ".$this->cantidad;
        }
        $this->mensajes = array();
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
    
    public function getTotal() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM mensajes";
        if (!is_null($this->filtro)) {
            $query .= $this->filtro;
        }
        if ($conn->ejecutar($query)) {
            return $conn->registros();
        }
        return FALSE;
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