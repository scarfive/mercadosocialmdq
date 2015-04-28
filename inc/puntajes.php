<?php
/*
  puntajes.php

  Permite manejar la tabla de puntajes de usuarios
 */
/*
  Created on : 27/04/2015, 23:45:17
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Puntajes {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "puntajes";
        $this->fields["codigo"] = array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["operacion"] = array("name" => "operacion", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["de"] = array("name" => "de", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["para"] = array("name" => "para", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["puntaje"] = array("name" => "puntaje", "flags" => "not_null unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["fecha"] = array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["observaciones"] = array("name" => "observaciones", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Puntajes($codigo = NULL) {
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

    function setOperacion($value) {
        $value = intval($value);
        $this->fields["operacion"]["value"] = $value;
        $this->fields["operacion"]["change"] = true;
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

    function setPuntaje($value) {
        $value = intval($value);
        $this->fields["puntaje"]["value"] = $value;
        $this->fields["puntaje"]["change"] = true;
    }

    function setFecha($value) {
        $this->fields["fecha"]["value"] = $value;
        $this->fields["fecha"]["change"] = true;
    }

    function setObservaciones($value) {
        $value = trim($value);
        $this->fields["observaciones"]["value"] = $value;
        $this->fields["observaciones"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getOperacion() {
        return $this->fields["operacion"]["value"];
    }

    function getDe() {
        return $this->fields["de"]["value"];
    }

    function getPara() {
        return $this->fields["para"]["value"];
    }

    function getPuntaje() {
        return $this->fields["puntaje"]["value"];
    }

    function getFecha() {
        return $this->fields["fecha"]["value"];
    }

    function getObservaciones() {
        return $this->fields["observaciones"]["value"];
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