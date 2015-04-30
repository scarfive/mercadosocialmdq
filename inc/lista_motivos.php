<?php
/*
    lista_motivos.php
    
    Implementa una lista de motivos
*/
/* 
    Created on : 29/04/2015, 17:34:09
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class ListaMotivos {
    
    private $motivos;

    public function __construct() {
        $this->motivos = array();
        $conn = new Conexion();
        $conn->conectar();
        $this->cargarMotivos($conn);
    }
    
    private function cargarMotivos($conn) {
        $select = "SELECT codigo FROM motivos ORDER BY descripcion";
        if (($result = $conn->ejecutar($select))) {
            while ($row = mysql_fetch_array($result)) {
                $this->motivos[] = new Motivos($row[0]);
            }
        }
    }
    
    public function getMotivos() {
        return $this->motivos;
    }
    
}
?>