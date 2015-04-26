<?php
/*
    mensajes.php
    
    Permite manejar la tabla Mensajes
*/
/* 
    Created on : 26/04/2015, 15:42:39
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class Mensajes {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "mensajes";
        $this->fields["codigo"] = array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["fecha"] = array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["de"] = array("name" => "de", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["para"] = array("name" => "para", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["mensaje"] = array("name" => "mensaje", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
        $this->fields["leido"] = array("name" => "leido", "flags" => "not_null multiple_key", "type" => "int", "len" => "1", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Mensajes($codigo = NULL) {
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

    function setDe($value) {
        $value = intval($value);
        $this->fields["de"]["value"] = $value;
        $this->fields["de"]["change"] = true;
    }

    function setPara($value) {
        $value = intval($value);
        $this->fields["para"]["value"] = $value;
        $this->fields["para"]["change"] = true;
    }

    function setMensaje($value) {
        $value = trim($value);
        $this->fields["mensaje"]["value"] = $value;
        $this->fields["mensaje"]["change"] = true;
    }

    function setLeido($value) {
        $value = intval($value);
        $this->fields["leido"]["value"] = $value;
        $this->fields["leido"]["change"] = true;
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

    function getDe() {
        return $this->fields["de"]["value"];
    }

    function getPara() {
        return $this->fields["para"]["value"];
    }

    function getMensaje() {
        return $this->fields["mensaje"]["value"];
    }

    function getLeido() {
        return $this->fields["leido"]["value"];
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