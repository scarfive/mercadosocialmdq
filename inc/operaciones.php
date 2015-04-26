<?php
/*
    operaciones.php
    
    Permite manejar la tabla de operaciones
*/
/* 
    Created on : 25/04/2015, 22:49:55
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class Operaciones {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "operaciones";
        $this->fields["codigo"] = array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["fecha"] = array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["monto"] = array("name" => "monto", "flags" => "not_null unsigned", "type" => "real", "len" => "8", "change" => false, "iskey" => 0);
        $this->fields["publicacion"] = array("name" => "publicacion", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["comprador"] = array("name" => "comprador", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["concretada"] = array("name" => "concretada", "flags" => "not_null multiple_key", "type" => "int", "len" => "1", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Operaciones($codigo = NULL) {
        $this->Mapping();
        if ($codigo != NULL) {
            $query = "select * from " . $this->table . " where codigo = $codigo";
            $conn = new Conexion();
            $conn->conectar();
            if (($result = $conn->ejecutar($query))) {
                if ($row = mysql_fetch_array($result)) {
                    foreach ($row as $key => $value) {
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

    function setFecha($value) {
        $this->fields["fecha"]["value"] = $value;
        $this->fields["fecha"]["change"] = true;
    }

    function setMonto($value) {
        $this->fields["monto"]["value"] = $value;
        $this->fields["monto"]["change"] = true;
    }

    function setPublicacion($value) {
        $value = intval($value);
        $this->fields["publicacion"]["value"] = $value;
        $this->fields["publicacion"]["change"] = true;
    }

    function setComprador($value) {
        $value = intval($value);
        $this->fields["comprador"]["value"] = $value;
        $this->fields["comprador"]["change"] = true;
    }

    function setConcretada($value) {
        $value = intval($value);
        $this->fields["concretada"]["value"] = $value;
        $this->fields["concretada"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getFecha() {
        return $this->fields["fecha"]["value"];
    }

    function getMonto() {
        return $this->fields["monto"]["value"];
    }

    function getPublicacion() {
        return $this->fields["publicacion"]["value"];
    }

    function getComprador() {
        return $this->fields["comprador"]["value"];
    }

    function getConcretada() {
        return $this->fields["concretada"]["value"];
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
                    $query .= $key . " = '" . htmlspecialchars(addslashes($this->fields[$key]["value"])) . "'";
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
                    $values .= "'" . htmlspecialchars(addslashes($this->fields[$key]["value"])) . "'";
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
        $query = "DELETE FROM " . $this->table . " WHERE codigo = " . $this->fields["codigo"]["value"];
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return TRUE;
    }

}

?>