<?php
/*
    listado_categorias.php
    
    Clase para  listado_categorias
*/
/* 
    Created on : 23/04/2015, 20:53:04
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListadoCategorias {
    
    private $categorias;
    private $cantidad;
    
    public function __construct() {
        $this->categorias = array();
        $conn = new Conexion();
        $conn->conectar();
        $this->cargarCategorias($conn);
    }
    
    private function cargarCategorias($conn) {
        $select = "SELECT * FROM categorias";
        if (($result = $conn->ejecutar($select))) {
            $this->cantidad = mysql_num_rows($result);
            while ($row = mysql_fetch_array($result)) {
                $this->categorias[] = new Categorias($row[0]);
            }
        }
    }
    
    public function getCategorias() {
        return $this->categorias;
    }
    
    public function getCantidad() {
        return $this->cantidad;
    }
    
}

?>