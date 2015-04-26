<?php
/*
    lista_respuestas.php
    
    Implementa una lista de respuestas
*/
/* 
    Created on : 25/04/2015, 21:18:21
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaRespuestas {
    
    private $respuestas;
    private $filtro;
    private $orden;
    private $puntero;

    public function __construct() {
        $this->respuestas = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroPregunta($pregunta) {
        $this->verificarFiltro();
        $this->filtro .= " pregunta = ".$pregunta;
    }
    
    public function setFiltroPublicacion($publicacion) {
        $this->verificarFiltro();
        $this->filtro .= " pregunta = (SELECT codigo FROM preguntas WHERE publicacion = ".$publicacion.")";
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " pregunta = (SELECT codigo FROM preguntas WHERE usuario = ".$usuario.")";
    }
    
    public function setOrdenFecha($dir = 'ASC') {
        $this->orden = " ORDER BY fecha ".$dir;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM respuestas";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($query))) {
            while ($row = mysql_fetch_array($result)) {
                $this->respuestas[] = new Respuestas($row[0]);
            }
        }
    }
    
    public function getRespuestas() {
        return $this->respuestas;
    }
    
    public function getCantidad() {
        return sizeof($this->respuestas);
    }
    
    public function getSiguienteRespuesta() {
        $respuesta = $this->respuestas[$this->puntero++];
        if ($this->puntero >= $this->getCantidad()) {
            $this->puntero = 0;
        }
        return $respuesta;
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