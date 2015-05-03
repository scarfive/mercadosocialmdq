<?php

/*
  Clase Usuarios

  Permite manejar la tabla Usuarios

  Created on : 18/04/2015, 01:16:17
  Author     : Juan Manuel Scarciofolo
  License    : GPLv3
 */

class Usuarios {

    private $table;
    private $fields = array();

    /* Mapeo de la tabla */

    private function Mapping() {
        $this->table = "usuarios";
        $this->fields["codigo"] = Array("name" => "codigo", "flags" => "not_null primary_key unsigned auto_increment", "type" => "int", "len" => "11", "change" => false, "iskey" => 1);
        $this->fields["apellido"] = Array("name" => "apellido", "flags" => "multiple_key", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
        $this->fields["nombre"] = Array("name" => "nombre", "flags" => "multiple_key", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
        $this->fields["apodo"] = Array("name" => "apodo", "flags" => "multiple_key", "type" => "string", "len" => "32", "change" => false, "iskey" => 0);
        $this->fields["domicilio"] = Array("name" => "domicilio", "flags" => "multiple_key", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
        $this->fields["telefono"] = Array("name" => "telefono", "flags" => "", "type" => "string", "len" => "16", "change" => false, "iskey" => 0);
        $this->fields["zona"] = Array("name" => "zona", "flags" => "not_null multiple_key", "type" => "int", "len" => "11", "change" => false, "iskey" => 0);
        $this->fields["correo"] = Array("name" => "correo", "flags" => "", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
        $this->fields["alta"] = Array("name" => "alta", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
        $this->fields["clave"] = Array("name" => "clave", "flags" => "", "type" => "string", "len" => "64", "change" => false, "iskey" => 0);
        $this->fields["resumen"] = Array("name" => "resumen", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
        $this->fields["imagen"] = Array("name" => "imagen", "flags" => "", "type" => "string", "len" => "256", "change" => false, "iskey" => 0);
        $this->fields["conexion"] = Array("name" => "conexion", "flags" => "multiple_key binary", "type" => "datetime", "len" => "19", "change" => false, "iskey" => 0);
    }

    /* Constructor */

    function Usuarios($codigo = NULL) {
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

    function setApellido($value) {
        $value = trim($value);
        $this->fields["apellido"]["value"] = $value;
        $this->fields["apellido"]["change"] = true;
    }

    function setNombre($value) {
        $value = trim($value);
        $this->fields["nombre"]["value"] = $value;
        $this->fields["nombre"]["change"] = true;
    }

    function setApodo($value) {
        $value = trim($value);
        $this->fields["apodo"]["value"] = $value;
        $this->fields["apodo"]["change"] = true;
    }

    function setDomicilio($value) {
        $value = trim($value);
        $this->fields["domicilio"]["value"] = $value;
        $this->fields["domicilio"]["change"] = true;
    }

    function setTelefono($value) {
        $value = trim($value);
        $this->fields["telefono"]["value"] = $value;
        $this->fields["telefono"]["change"] = true;
    }

    function setZona($value) {
        $value = intval($value);
        $this->fields["zona"]["value"] = $value;
        $this->fields["zona"]["change"] = true;
    }

    function setCorreo($value) {
        $value = trim($value);
        $this->fields["correo"]["value"] = $value;
        $this->fields["correo"]["change"] = true;
    }

    function setAlta($value) {
        $this->fields["alta"]["value"] = $value;
        $this->fields["alta"]["change"] = true;
    }

    function setClave($value) {
        $value = trim($value);
        $this->fields["clave"]["value"] = $value;
        $this->fields["clave"]["change"] = true;
    }

    function setResumen($value) {
        $value = trim($value);
        $this->fields["resumen"]["value"] = $value;
        $this->fields["resumen"]["change"] = true;
    }

    function setImagen($value) {
        $value = trim($value);
        $this->fields["imagen"]["value"] = $value;
        $this->fields["imagen"]["change"] = true;
    }

    function setConexion($value) {
        $this->fields["conexion"]["value"] = $value;
        $this->fields["conexion"]["change"] = true;
    }

    /*
     * Metodos Get 
     * Permiten acceder a las propiedades de la clase
     */

    function getCodigo() {
        return $this->fields["codigo"]["value"];
    }

    function getApellido() {
        return $this->fields["apellido"]["value"];
    }

    function getNombre() {
        return $this->fields["nombre"]["value"];
    }

    function getApodo() {
        return $this->fields["apodo"]["value"];
    }

    function getDomicilio() {
        return $this->fields["domicilio"]["value"];
    }

    function getTelefono() {
        return $this->fields["telefono"]["value"];
    }

    function getZona() {
        return $this->fields["zona"]["value"];
    }

    function getCorreo() {
        return $this->fields["correo"]["value"];
    }

    function getAlta() {
        return $this->fields["alta"]["value"];
    }

    function getClave() {
        return $this->fields["clave"]["value"];
    }

    function getResumen() {
        return $this->fields["resumen"]["value"];
    }

    function getImagen() {
        return $this->fields["imagen"]["value"];
    }

    function getConexion() {
        return $this->fields["conexion"]["value"];
    }

    /* Metodo Update */

    function update() {
        $query = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key]["change"] && $key != 'imagen') {
                if ($query != "") {
                    $query .= ", ";
                }
                if ($this->fields[$key]["type"] == "int") {
                    $query .= $key . " = " . intval($this->fields[$key]["value"]);
                } else {
                    if ($this->fields[$key]["name"] == "clave") {
                        $query .= $key . " = MD5('" . textoSQL($this->fields[$key]["value"]) . "')";
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
        $handler = new ImageHandler('imagen');
        if ($handler->loadImages()) {
            $img = $handler->getImageNames();
            $query = "UPDATE " . $this->table . " SET imagen = '".$img[0]."' WHERE codigo = ".$this->fields["codigo"]["value"];
            if (!$conn->ejecutar($query)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /* Metodo Insert */

    function insert($temp = FALSE) {
        $fields = "";
        $values = "";
        foreach ($this->fields as $key => $value) {
            if ($this->fields[$key]["change"] && $key != 'imagen') {
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
                    if ($this->fields[$key]["name"] == "clave") {
                        $values .= "MD5('" . textoSQL($this->fields[$key]["value"]) . "')";
                    } else {
                        $values .= "'" . textoSQL($this->fields[$key]["value"]) . "'";
                    }
                }
            }
        }
        if (trim($fields) == "" || trim($values) == "") {
            return false;
        }
        $query = "INSERT INTO ";
        if ($temp) {
            $query .= "tmp_";
        }
        $query .= $this->table . " (" . $fields . ", alta) VALUES (" . $values . ", now())";
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        $handler = new ImageHandler('imagen');
        if ($handler->loadImages()) {
            $img = $handler->getImageNames();
            $query = "UPDATE " . $this->table . " SET imagen = '".$img[0]."' WHERE codigo = ".$this->fields['codigo']["value"];
            if (!$conn->ejecutar($query)) {
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

    /* Permite saber si un apodo ha sido usado */

    function verificarApodo($apodo) {
        return "select codigo from " . $this->table . " where apodo = '" . $apodo . "'";
    }

    /* Permite saber si un correo ya ha sido registrado */

    function verificarCorreo($correo) {
        return "select codigo from " . $this->table . " where correo = '" . $correo . "'";
    }

}

?>