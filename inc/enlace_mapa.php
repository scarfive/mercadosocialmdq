<?php
/*
    enlace_mapa.php
    
    Permite ver un enlace para ubicar una direccion en los mapas de google
*/
/* 
    Created on : 02/05/2015, 20:30:44
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/
class EnlaceMapa {
    
    private $calle;
    private $altura;

    public function __construct($calle, $altura) {
        $this->calle = $calle;
        $this->altura = $altura;
    }
    
    public function show() {
        $client = new nusoap_client("http://gisdesa.mardelplata.gob.ar/opendata/ws.php/");
        
        if ($client->getError()) {
            print '[ Enlace a mapa no disponible ]';
            return;
        }
        
        $result = $client->call("callejero_mgp", array("nombre_calle" => $this->calle, "token" => "wwfe345gQ3ed5T67g4Dase45F6fer"));
        
        $cod_calle = $result[0]['codigo'];
        
        $result = $client->call("callealtura_coordenada", array("codigocalle" => $cod_calle, "altura" => $this->altura, "token" => "wwfe345gQ3ed5T67g4Dase45F6fer"));
        
        print '<a href="http://www.google.com.ar/maps/place/'.$result['lat'].','.$result['lng'].'" class="ui-enlace-mapa">☛ Ver en el mapa</a>';
    }
    
}
?>