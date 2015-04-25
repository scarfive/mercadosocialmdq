<?php
/*
    lista_categorias.php
    
    Una lista de categorias
*/
/* 
    Created on : 20/04/2015, 00:58:46
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class ListaCategorias {
    
    private $categorias;

    public function __construct() {
        $this->categorias = array();
        $conn = new Conexion();
        $conn->conectar();
        $this->cargarCategorias($conn);
    }
    
    private function cargarCategorias($conn) {
        $select = "SELECT codigo FROM categorias ORDER BY descripcion";
        if (($result = $conn->ejecutar($select))) {
            while ($row = mysql_fetch_array($result)) {
                $this->categorias[] = new Categorias($row[0]);
            }
        }
    }
    
    public function getCategorias() {
        return $this->categorias;
    }
    
}
?>