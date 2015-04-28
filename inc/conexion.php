<?php

    class Conexion {
        
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '27416103';
        private $db = 'mercadosocial';
        
        private static $link;
        
        private $result;
        
        /**
         * PERMITE ESTABLECER LA CONEXION CON LA BASE DE DATOS.
         */
        public function conectar() {
            $this->link = mysql_connect($this->host, $this->user, $this->pass);
            if (!$this->link) {
                return FALSE;
            }
            mysql_select_db($this->db);
            mysql_query('SET NAMES "utf8"');
            return TRUE;
        }
        
        /**
         * RETORNA EL CODIGO GENERADO DE LA ULTIMA CONSULTA INSERT.
         */
        public function indice() {
            return mysql_insert_id($this->link);
        }
        
        /**
         * PERMITE VERIFICAR SI UNA CONSULTA DEVUELVE UN VALOR.
         */
        public function verificar($query) {
            $this->result = mysql_query($query, $this->link);
            if (!$this->result || mysql_num_rows($result) < 1) {
                return FALSE;
            }
            return TRUE;
        }
        
        /**
         * PERMITE EJECUTAR UNA CONSULTA SOBRE LA BASE DE DATOS.
         */
        public function ejecutar($query) {
            $this->result = mysql_query($query, $this->link);
            return $this->result;
        }
        
        /**
         * DEVUELVE LA CANTIDAD DE REGISTROS OBTENIDOS EN LA ULTIMA CONSULTA.
         */
        public function registros() {
            return mysql_num_rows($this->result);
        }
        
        /**
         * RETORNA EL VALOR DE UNA FILA Y COLUMNA DETERMINADAS EN UNA CONSULTA YA REALIZADA.
         */
        public function valor($fila = 0, $col = 0) {
            return mysql_result($this->result, $fila, $col);
        }
        
    }

?>