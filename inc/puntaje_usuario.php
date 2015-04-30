<?php
/*
    puntaje_usuario.php
    
    Determina el puntaje de un usuario
*/
/* 
    Created on : 30/04/2015, 17:30:57
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class PuntajeUsuario {
    
    private $usuario;
    private $puntaje;

    public function __construct($usuario) {
        $this->usuario = $usuario;
        $this->puntaje = 0;
    }
    
    public function calcular() {
        $query = "SELECT AVG(puntaje) FROM puntajes WHERE para = ".$this->usuario;
        $conn = new Conexion();
        $conn->conectar();
        if (!$conn->ejecutar($query)) {
            return FALSE;
        }
        return number_format($conn->valor(), 1);
    }
    
}

?>