<?php
/*
  productos.php

  Clase para el manejo de la tabla productos
 */
/*
  Created on : 19/04/2015, 21:07:25
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Productos {

    private $table;
    private $fields = array();
    private $connection = NULL;

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "productos";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["descripcion"] = Array("name" => "descripcion", "flags" => "multiple_key", "type" => "string", "len" => "128", "change" => false, "iskey" => 0);
        $this->fields["precio"] = Array("name" => "precio", "flags" => "not_null multiple_key unsigned", "type" => "real", "len" => "8", "change" => false, "iskey" => 0);
        $this->fields["resumen"] = Array("name" => "resumen", "flags" => "blob", "type" => "blob", "len" => "65535", "change" => false, "iskey" => 0);
        $this->fields["usuario"] = Array("name" => "usuario", "flags" => "not_null multiple_key", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["categorias"] = Array("name" => "categorias", "flags" => "multiple_key", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
        $this->fields["imagenes"] = Array("name" => "imagenes", "flags" => "multiple_key", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Productos($codigo = NULL) {
        $this->Mapping();
        if($codigo != NULL) {
            $conn = new Conexion();
            $conn->conectar();
            $this->cargarDatos($codigo, $conn);
            $this->cargarCategorias($codigo, $conn);
            $this->cargarImagenes($codigo, $conn);
        }
    }
    
    private function cargarDatos($codigo, $conn) {
        $select = "SELECT * FROM ".$this->table." WHERE codigo = ".$codigo;
        if ($result = $conn->ejecutar($select)) {
            if ($row = mysql_fetch_array($result)) {
                foreach ($row as $key=>$value) {
                    $this->fields[$key]["value"] = $value;
                }
            }
        }
    }
    
    private function cargarCategorias($codigo, $conn) {
        $cats = array();
        $select = "SELECT categoria, descripcion FROM cat_productos, categorias WHERE cat_productos.categoria = categorias.codigo AND cat_productos.producto = ".$codigo;
        if ($result = $conn->ejecutar($select)) {
            while ($row = mysql_fetch_array($result)) {
                $cats[] = array('codigo' => $row['categoria'], 'descripcion' => $row['descripcion']);
            }
            $this->fields['categorias']["value"] = $cats;
        }
    }
    
    private function cargarImagenes($codigo, $conn) {
        $imgs = array();
        $select = "SELECT * FROM img_productos WHERE producto = ".$codigo;
        if ($result = $conn->ejecutar($select)) {
            while ($row = mysql_fetch_array($result)) {
                $imgs[] = array('codigo' => $row['codigo'], 'imagen' => $row['imagen']);
            }
            $this->fields['imagenes']["value"] = $imgs;
        }
    }

    /*
     * Metodos Set 
     * Permiten determinar las propiedades de la clase
     */

    function setCodigo($value) {
        $value = intval($value);
        $this->fields["codigo"]["value"] = $value;
        $this->fields["codigo"]["change"] = true;
    }

    function setDescripcion($value) {
        $value = trim($value);
        $this->fields["descripcion"]["value"] = $value;
        $this->fields["descripcion"]["change"] = true;
    }

    function setPrecio($value) {
        $this->fields["precio"]["value"] = $value;
        $this->fields["precio"]["change"] = true;
    }

    function setResumen($value) {
        $this->fields["resumen"]["value"] = $value;
        $this->fields["resumen"]["change"] = true;
    }

    function setUsuario($value) {
        $value = intval($value);
        $this->fields["usuario"]["value"] = $value;
        $this->fields["usuario"]["change"] = true;
    }

    function setCategorias($value) {
        $this->fields["categorias"]["value"] = $value;
        $this->fields["categorias"]["change"] = true;
    }

    function setImagenes($value) {
        $this->fields["imagenes"]["value"] = $value;
        $this->fields["imagenes"]["change"] = true;
    }
    
    function setConnection($conn) {
        $this->connection = $conn;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getDescripcion() {
        return $this->fields["descripcion"]["value"];
    }

    function getPrecio() {
        return $this->fields["precio"]["value"];
    }

    function getResumen() {
        return $this->fields["resumen"]["value"];
    }

    function getUsuario() {
        return $this->fields["usuario"]["value"];
    }

    function getCategorias() {
        return $this->fields["categorias"]["value"];
    }

    function getImagenes() {
        return $this->fields["imagenes"]["value"];
    }

    /* Metodo Update */

    function update() {
        $query = "";
        foreach ($this->fields as $key => $value) {
            if ($key != 'categorias' && $key != 'imagenes') {
                if ($this->fields[$key]["change"]) {
                    if ($query != "") {
                        $query .= ", ";
                    }
                    if ($this->fields[$key]["type"] == "int") {
                        $query .= $key . " = " . intval($this->fields[$key]["value"]);
                    } else {
                        $query .= $key . " = '" . textoSQL($this->fields[$key]["value"]) . "'";
                    }
                }
            }
        }
        if (trim($query) == "") {
            return false;
        }
        $query = "UPDATE " . $this->table . " SET " . $query . " WHERE codigo = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        if ($this->fields["categorias"]["change"]) {
            $conn->ejecutar("DELETE FROM cat_productos WHERE producto = ".$this->fields["codigo"]["value"]);
            if (!$this->agregarCategorias($conn, $this->fields["codigo"]["value"])) {
                return FALSE;
            }
        }
        $handler = new ImageHandler('imagenes', 3);
        if ($handler->loadImages()) {
            $arr_img = $handler->getImageNames();
            $index = 0;
            $query = '';
            foreach ($arr_img as $img) {
                if (!empty($img)) {
                    $query = "UPDATE img_productos SET imagen = '".$img."' WHERE codigo = ".$this->fields["imagenes"]["value"][$index]['codigo'];
                    if (!$conn->ejecutar($query)) {
                        return FALSE;
                    }
                }
                $index++;
            }
        }
        return TRUE;
    }

    /* Metodo Insert */

    function insert() {
        $fields = "";
        $values = "";
        foreach ($this->fields as $key => $value) {
            if ($key != 'categorias' && $key != 'imagenes') {
                if ($this->fields[$key]["change"]) {
                    if ($fields != "") {
                        $fields .= ", ";
                    }
                    $fields .= $key;
                    if ($values != "") {
                        $values .= ", ";
                    }
                    if ($this->fields[$key]["type"] == "int") {
                        $values .= intval($this->fields[$key]["value"]);
                    } else {
                        $values .= "'" . textoSQL($this->fields[$key]["value"]) . "'";
                    }
                }
            }
        }
        if (trim($fields) == "" || trim($values) == "") {
            return false;
        }
        $query = "INSERT INTO " . $this->table . " (" . $fields . ") VALUES (" . $values . ")";
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $codigo_producto = $conn->indice();
        if ($this->fields["categorias"]["change"]) {
            if (!$this->agregarCategorias($conn, $codigo_producto)) {
                return FALSE;
            }
        }
        $handler = new ImageHandler('imagenes', 3);
        if ($handler->loadImages()) {
            $arr_img = $handler->getImageNames();
            print_r($arr_img);
            $query = "INSERT INTO img_productos (imagen, producto) VALUES ";
            foreach ($arr_img as $img) {
                $query .= "('".$img."', ".$codigo_producto."),";
            }
            if (!$conn->ejecutar(quitarUltimoCaracter($query))) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /* Metodo Delete */

    function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE codigo = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }
    
    private function agregarCategorias($conn, $codigo_producto) {
        $query = "INSERT INTO cat_productos (categoria, producto) VALUES ";
        foreach ($this->fields["categorias"]["value"] as $cat) {
            $query .= "(".$cat.", ".$codigo_producto."),";
        }
        if (!$conn->ejecutar(quitarUltimoCaracter($query))) {
            return FALSE;
        }
        return TRUE;
    }
    
    private function agregarImagenes($conn, $codigo_producto) {
        $arr_img = $handler->getImageNames();
        $query = "INSERT INTO img_productos (imagen, producto) VALUES ";
        foreach ($arr_img as $img) {
            if (!empty($img)) {
                $query .= "('".$img."', ".$codigo_producto."),";
            }
        }
        if (!$conn->ejecutar(quitarUltimoCaracter($query))) {
            return FALSE;
        }
        return TRUE;
    }
    
    /* Indica si un producto ha sido publicado */
    
    function is_published() {
        $query = "SELECT codigo FROM publicaciones WHERE producto = " . $this->fields["codigo"]["value"] . " AND activa = 1 ";
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return $conn->valor();
    }
    
    /* Devuelve la calificacion del producto */

    function getCalificacion() {
        $query = "SELECT AVG(calificacion) FROM calificaciones WHERE producto = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $valor = $conn->valor();
        if (empty($valor)) {
            return 0;
        }
        return $valor;
    }
    
    /* Devuelve los comentarios del producto */

    function getComentarios() {
        $query = "SELECT COUNT(*) FROM calificaciones WHERE producto = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $valor = $conn->valor();
        if (empty($valor)) {
            return 0;
        }
        return $valor;
    }
    
    /* Devuelve la publicacion actual donde se encuentra el producto */
    
    function getPublicacion() {
        $query = "SELECT codigo FROM publicaciones WHERE producto = " . $this->fields["codigo"]["value"] . " ORDER BY fecha DESC";
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $valor = $conn->valor();
        if (empty($valor)) {
            return 0;
        }
        return $valor;
    }

}
?>