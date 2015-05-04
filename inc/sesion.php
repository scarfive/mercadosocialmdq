<?php
    
    class Sesion {
        
        public function iniciar() {
            session_start();
        }
        
        public function login() {
            $query = "SELECT codigo FROM usuarios WHERE apodo = '".$_REQUEST['u']."' AND clave = MD5('".$_REQUEST['p']."')";
            $result = mysql_query($query);
            if ($result && mysql_num_rows($result) > 0) {
                $intervalo = time() + 7*24*60*60;
                $id_sesion = getRandomId();
                $row = mysql_fetch_array($result);
                $codigo_usuario = $row[0];
                $query = "UPDATE usuarios SET conexion = ".$id_sesion." WHERE codigo = ".$codigo_usuario;
                if (!mysql_query($query)) {
                    return FALSE;
                }
                setcookie("session_haybale", $codigo_usuario, $intervalo, "/");
                setcookie("session_harvest", $id_sesion, $intervalo, "/");
                return TRUE;
            }
            return FALSE;
        }
        
        public function logout() {
            setcookie("session_haybale", "xxx", time() - 3600, "/");
            setcookie("session_harvest", "xxx", time() - 3600, "/");
        }
        
        public function is_logged() {
            return isset($_COOKIE["session_haybale"]);
        }
        
        public function get_user() {
            if ($this->is_logged()) {
                $result = mysql_query("SELECT * FROM usuarios WHERE codigo = ".$_COOKIE["session_haybale"]." AND clave = '".$_COOKIE["session_harvest"]."'");
                return mysql_fetch_array($result);
            }
            return NULL;
        }
        
        public function get_user_id() {
            if ($this->is_logged()) {
                return $_COOKIE["session_haybale"];
            }
            return NULL;
        }
        
        public function get_user_name() {
            if ($this->is_logged()) {
                $result = mysql_query("SELECT apodo FROM usuarios WHERE codigo = ".$_COOKIE["session_haybale"]." AND clave = '".$_COOKIE["session_harvest"]."'");
                return mysql_result($result, 0);
            };
            return NULL;
        }
        
        public function log() {
            return mysql_query("INSERT INTO usuarios_registro ( usuario, fecha, ip, session ) VALUES ( ".$this->get_user_id().", now(), '".$this->get_ip()."', '".session_id()."' )");
        }
        
        public function verify() {
            return mysql_query("SELECT * FROM usuarios_registro WHERE usuario = ".$this->get_user_id()." AND fecha < now() AND ip = '".$this->get_user_id()."' AND session = '".session_id()."'");
        }
        
        public function get_ip() {
            $ip = "0.0.0.0";
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            if (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
        
        public function get_user_avatar() {
            if ($this->is_logged()) {
                $result = mysql_query("SELECT avatar FROM usuarios WHERE codigo = ".$_COOKIE["session_haybale"]." AND clave = '".$_COOKIE["session_harvest"]."'");
                return mysql_result($result, 0);
            }
            return NULL;
        }
        
    }

?>