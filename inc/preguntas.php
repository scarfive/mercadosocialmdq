<?php

/*
  Clase Preguntas

  Permite manejar la tabla Preguntas

  Created on : 25/04/2015, 01:49:31
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Preguntas {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "preguntas";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["publicacion"] = Array("name" => "publicacion", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["usuario"] = Array("name" => "usuario", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["fecha"] = Array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["pregunta"] = Array("name" => "pregunta", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Preguntas($codigo = NULL) {
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

    function setPublicacion($value) {
        $value = intval($value);
        $this->fields["publicacion"]["value"] = $value;
        $this->fields["publicacion"]["change"] = true;
    }

    function setUsuario($value) {
        $value = intval($value);
        $this->fields["usuario"]["value"] = $value;
        $this->fields["usuario"]["change"] = true;
    }

    function setFecha($value) {
        $this->fields["fecha"]["value"] = $value;
        $this->fields["fecha"]["change"] = true;
    }

    function setPregunta($value) {
        $value = trim($value);
        $this->fields["pregunta"]["value"] = $value;
        $this->fields["pregunta"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getPublicacion() {
        return $this->fields["publicacion"]["value"];
    }

    function getUsuario() {
        return $this->fields["usuario"]["value"];
    }

    function getFecha() {
        return $this->fields["fecha"]["value"];
    }

    function getPregunta() {
        return $this->fields["pregunta"]["value"];
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
    
    /* Indica la cantidad de preguntas sin leer */
    
    function getPendientes() {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE leida = 0";
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