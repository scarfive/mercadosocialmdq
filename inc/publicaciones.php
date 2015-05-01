<?php

/*
  publicaciones.php

  Clase para el manejo de la tabla publicaciones
 */
/*
  Created on : 22/04/2015, 11:59:32
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Publicaciones {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "publicaciones";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["producto"] = Array("name" => "producto", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["precio"] = Array("name" => "precio", "flags" => "not_null multiple_key unsigned", "type" => "real", "len" => "8", "change" => false, "iskey" => 0);
        $this->fields["fecha"] = Array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["limite"] = Array("name" => "limite", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["vistas"] = Array("name" => "vistas", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "10", "change" => false, "iskey" => 0);
        $this->fields["activa"] = Array("name" => "activa", "flags" => "not_null multiple_key", "type" => "int", "len" => "1", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Publicaciones($codigo = NULL) {
        $this->Mapping();
        if ($codigo != NULL) {
            $select = "select * from ".$this->table." where codigo = ".$codigo;
            $conn = new Conexion();
            $conn->conectar();
            if($result = $conn->ejecutar($select)) {
                if($row = mysql_fetch_array($result)) {
                    foreach($row as $key=>$value) {
                        $this->fields[$key]["value"] = $value;
                    }
                }
            }
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

    function setProducto($value) {
        $value = intval($value);
        $this->fields["producto"]["value"] = $value;
        $this->fields["producto"]["change"] = true;
    }

    function setPrecio($value) {
        $this->fields["precio"]["value"] = $value;
        $this->fields["precio"]["change"] = true;
    }

    function setFecha($value) {
        $this->fields["fecha"]["value"] = $value;
        $this->fields["fecha"]["change"] = true;
    }

    function setLimite($value) {
        $this->fields["limite"]["value"] = $value;
        $this->fields["limite"]["change"] = true;
    }

    function setVistas($value) {
        $this->fields["vistas"]["value"] = $value;
        $this->fields["vistas"]["change"] = true;
    }

    function setActiva($value) {
        $value = intval($value);
        $this->fields["activa"]["value"] = $value;
        $this->fields["activa"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getProducto() {
        return $this->fields["producto"]["value"];
    }

    function getPrecio() {
        return $this->fields["precio"]["value"];
    }

    function getFecha() {
        return $this->fields["fecha"]["value"];
    }

    function getLimite() {
        return $this->fields["limite"]["value"];
    }

    function getVistas() {
        return $this->fields["vistas"]["value"];
    }

    function getActiva() {
        return $this->fields["activa"]["value"];
    }

    /* Metodo Update */

    function update() {
        $query = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key]["change"] == true) {
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
        if (trim($query) == "") {
            return false;
        }
        $query = "UPDATE " . $this->table . " SET " . $query . " WHERE codigo = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }

    /* Metodo Insert */

    function insert() {
        $fields = "";
        $values = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key]["change"] == true) {
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
        if (trim($fields) == "" || trim($values) == "") {
            return false;
        }
        $query = "INSERT INTO " . $this->table . " (" . $fields . ") VALUES (" . $values . ")";
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }

    /* Metodo Delete */

    function delete() {
        $conn = new Conexion();
        $conn->conectar();
        $query = "INSERT INTO publicaciones_canceladas SELECT * FROM " . $this->table . " WHERE codigo = " . $this->fields["codigo"]["value"];
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $query = "DELETE FROM " . $this->table . " WHERE codigo = " . $this->fields["codigo"]["value"];
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }
    
    /* Suma uno al indicador de publicacion vista */
    
    function sumarVista() {
        $query = "UPDATE " . $this->table . " SET vistas = vistas + 1 WHERE codigo = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }

}

?>