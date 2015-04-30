<?php
/*
    lista_productos.php
    
    Implementa una lista de productos
*/
/* 
    Created on : 30/04/2015, 16:03:15
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class ListaProductos {
    
    private $productos;
    private $filtro;
    private $orden;
    private $puntero;

    public function __construct() {
        $this->productos = array();
        $this->filtro = NULL;
        $this->orden = NULL;
        $this->puntero = 0;
    }
    
    public function setFiltroUsuario($usuario) {
        $this->verificarFiltro();
        $this->filtro .= " usuario = ".$usuario;
    }
    
    public function setFiltroPublicados($publicado = FALSE) {
        $this->verificarFiltro();
        $condicion = " codigo";
        if (!$publicado) {
            $this->filtro .= " NOT";
        }
        $condicion .= " IN (SELECT producto FROM publicaciones)";
    }
    
    public function setFiltroCategorias($categoria, $usuario) {
        $this->verificarFiltro();
        $this->filtro .= " codigo IN (SELECT producto FROM cat_productos, productos WHERE producto = codigo AND categoria = ".$categoria." AND usuario = ".$usuario.")";
    }
    
    public function borrarFiltro() {
        $this->filtro = NULL;
    }
    
    public function setOrdenCodigo($dir = 'ASC') {
        $this->orden = " ORDER BY codigo ".$dir;
    }
    
    public function setOrdenDescripcion($dir = 'ASC') {
        $this->orden = " ORDER BY descripcion ".$dir;
    }
    
    public function cargarLista() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT codigo FROM productos";
        if (!empty($this->filtro)) {
            $query .= $this->filtro;
        }
        if (!empty($this->orden)) {
            $query .= $this->orden;
        }
        if (($result = $conn->ejecutar($query))) {
            while ($row = mysql_fetch_array($result)) {
                $this->productos[] = new Productos($row[0]);
            }
        }
    }
    
    public function getProductos() {
        return $this->productos;
    }
    
    public function getCantidad() {
        return sizeof($this->productos);
    }
    
    public function getSiguienteOperacion() {
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