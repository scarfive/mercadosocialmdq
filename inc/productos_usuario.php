<?php
/*
    productos_usuario.php
    
    Clase que contiene los productos de un usuario determinado
*/
/* 
    Created on : 19/04/2015, 23:01:17
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ProductosUsuario {
    
    private $usuario;
    private $productos;
    private $cantidad;

    public function __construct($usuario) {
        $this->usuario = $usuario;
        $this->productos = array();
        $conn = new Conexion();
        $conn->conectar();
        $this->cargarProductos($conn);
    }
    
    private function cargarProductos($conn) {
        $select = "SELECT codigo FROM productos WHERE usuario = ".$this->usuario;
        if (($result = $conn->ejecutar($select))) {
            $this->cantidad = mysql_num_rows($result);
            while ($row = mysql_fetch_array($result)) {
                $this->productos[] = new Productos($row[0]);
            }
        }
    }
    
    public function getProductos() {
        return $this->productos;
    }
    
    public function getCantidadProductos() {
        return $this->cantidad;
    }
    
}
?>