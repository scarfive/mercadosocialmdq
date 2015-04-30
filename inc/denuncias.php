<?php

/*
  Clase Denuncias

  Permite manejar la tabla Denuncias

  Created on : 29/04/2015, 17:32:02
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Denuncias {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "denuncias";
        $this->fields["codigo"] = array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["fecha"] = array("name" => "fecha", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["de"] = array("name" => "de", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["para"] = array("name" => "para", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["operacion"] = array("name" => "operacion", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["publicacion"] = array("name" => "publicacion", "flags" => "not_null multiple_key unsigned", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["denuncia"] = array("name" => "denuncia", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
        $this->fields["motivos"] = array("name" => "motivos", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Denuncias($codigo = NULL) {
        $this->Mapping();
        if ($codigo != NULL) {
            $query = "SELECT * FROM " . $this->table . " WHERE codigo = $codigo";
            $conn = new Conexion();
            $conn->conectar();
            if (($result = $conn->ejecutar($query))) {
                if ($row = mysql_fetch_array($result)) {
                    foreach ($row as $key => $value) {
                        $this->fields[$key]["value"] = $value;
                    }
                }
            }
            $query = "SELECT codigo, descripcion FROM mot_denuncias, motivos WHERE motivos.codigo = mot_denuncias.motivo AND mot_denuncia.denuncia = $codigo";
            $motivos = array();
            if (($result = $conn->ejecutar($query))) {
                if ($row = mysql_fetch_array($result)) {
                    foreach ($row as $key => $value) {
                        $motivos[] = array('codigo' => $row['codigo'], 'descripcion' => $row['descripcion']);
                    }
                }
            }
            $this->fields['motivos']["value"] = $motivos;
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

    function setOperacion($value) {
        $value = intval($value);
        $this->fields["operacion"]["value"] = $value;
        $this->fields["operacion"]["change"] = true;
    }

    function setPublicacion($value) {
        $value = intval($value);
        $this->fields["publicacion"]["value"] = $value;
        $this->fields["publicacion"]["change"] = true;
    }
    function setDenuncia($value) {
        $value = trim($value);
        $this->fields["denuncia"]["value"] = $value;
        $this->fields["denuncia"]["change"] = true;
    }

    function setMotivos($value) {
        $this->fields["motivos"]["value"] = $value;
        $this->fields["motivos"]["change"] = true;
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

    function getOperacion() {
        return $this->fields["operacion"]["value"];
    }

    function getPublicacion() {
        return $this->fields["publicacion"]["value"];
    }

    function getDenuncia() {
        return $this->fields["denuncia"]["value"];
    }

    function getMotivos() {
        return $this->fields["motivos"]["value"];
    }

    /* Metodo Update */

    function update() {
        /*$query = "";
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
        return TRUE;*/
    }

    /* Metodo Insert */

    function insert() {
        $fields = "";
        $values = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key]["change"] == true) {
                if ($key != 'motivos') {
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
        $codigo_denuncia = $conn->indice();
        if ($this->fields["motivos"]["change"]) {
            if (!$this->agregarMotivos($conn, $codigo_denuncia)) {
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
    
    private function agregarMotivos($conn, $codigo_denuncia) {
        $query = "INSERT INTO mot_denuncias (motivo, denuncia) VALUES ";
        foreach ($this->fields["motivos"]["value"] as $mot) {
            $query .= "(".$mot.", ".$codigo_denuncia."),";
        }
        if (!$conn->ejecutar(quitarUltimoCaracter($query))) {
            return FALSE;
        }
        return TRUE;
    }

}

?>