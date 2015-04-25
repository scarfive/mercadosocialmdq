<?php
/*
  categorias.php

  Clase de la tabla categorias
 */
/*
  Created on : 20/04/2015, 00:50:37
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Categorias {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "categorias";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["descripcion"] = Array("name" => "descripcion", "flags" => "multiple_key", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Categorias($codigo = NULL) {
        $this->Mapping();
        if ($codigo != NULL) {
            $select = "select * from " . $this->table . " where codigo = " . $codigo;
            $conn = new Conexion();
            $conn->conectar();
            if ($result = $conn->ejecutar($select)) {
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

    function setDescripcion($value) {
        $value = trim($value);
        $this->fields["descripcion"]["value"] = $value;
        $this->fields["descripcion"]["change"] = true;
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

    /* Metodo Update */

    function update() {
        $query = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key][change] = true) {
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
        return "update " . $this->table . " set " . $query . " where codigo = " . $this->fields["codigo"]["value"];
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
                    $values .= intval($this->fields[$key]["value"]);
                } else {
                    $values .= "'" . textoSQL($this->fields[$key]["value"]) . "'";
                }
            }
        }
        if (trim($fields) == "" || trim($values) == "") {
            return false;
        }
        return "insert into " . $this->table . " (" . $fields . ") values (" . $values . ") where codigo = " . $this->fields["codigo"]["value"];
    }

    /* Metodo Delete */

    function delete() {
        return "delete from " . $this->table . " where codigo = " . $this->fields["codigo"]["value"];
    }

}
?>