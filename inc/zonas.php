<?php

/*
  Clase Zonas

  Permite manejar la tabla Zonas

  Created on : 18/04/2015, 17:15:09
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Zonas {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "zonas";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["zona"] = Array("name" => "zona", "flags" => "multiple_key", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Zonas($codigo = NULL) {
        $this->Mapping();
        if ($codigo != NULL) {
            $query = "SELECT * FROM " . $this->table . " WHERE codigo = $codigo";
            $conn = new Conexion();
            $conn->conectar();
            if ($result = $conn->ejecutar($query)) {
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

    function setZona($value) {
        $value = trim($value);
        $this->fields["zona"]["value"] = $value;
        $this->fields["zona"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getZona() {
        return $this->fields["zona"]["value"];
    }
    
    function getZonas() {
        return "select * from zonas";
    }

    /* Metodo Update */

    function update() {
        $query = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key][change] = true) {
                if ($query != "") {
                    $query .= ", ";
                }
                if ($this->fields[$key]["type"] == "int") {
                    $query .= $key . " = " . intval($value);
                } else {
                    $query .= $key . " = '" . textoSQL($value) . "'";
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
            if ($this->fields[$key][change] = true) {
                if ($fields != "") {
                    $fields .= ", ";
                }
                $fields .= $key;
                if ($values != "") {
                    $values .= ", ";
                }
                if ($this->fields[$key]["type"] == "int") {
                    $values .= intval($value);
                } else {
                    $values .= "'" . textoSQL($value) . "'";
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