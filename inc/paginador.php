<?php
/*
    paginador.php
    
    Implementa la paginacion de elementos
*/
/* 
    Created on : 02/05/2015, 11:49:36
    Author     : Juan Manuel Scarciofolo
    License    : GPLv3
*/

class Paginador {
    
    private $cantidad;
    private $total;
    private $numero_paginadores;

    public function __construct($cantidad, $total) {
        $this->cantidad = $cantidad;
        $this->total = $total;
        $this->numero_paginadores = ceil($this->total/$this->cantidad);
    }
    
    public function show() {
        print '<div class="paginador">';
        print '<ul>';
        for ($index = 0; $index < $this->numero_paginadores; $index++) {
            $inicio = $this->cantidad*$index;
            print '<li>';
            $enlace = new Enlace('pagina'.$index, $index + 1, $this->setURI($inicio));
            $enlace->add_class('ui-mini-boton');
            if ($this->is_current($inicio)) {
                $enlace->add_class('ui-boton-naranja');
            }
            else {
                $enlace->add_class('ui-boton-verde');
            }
            $enlace->show();
            print '</li>';
        }
        print '</ul>';
        print '</div>';
    }
    
    private function setURI($inicio) {
        $url = NULL;
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        if (isset($url_components['query'])) {
            if (preg_match('/inicio=[0-9]+/', $url_components['query'])) {
                $url_components['query'] = preg_replace('/inicio=[0-9]+/', 'inicio='.$inicio, $url_components['query']);
                $url = $url_components['path'].'?'.$url_components['query'];
            }
            else {
                $url = $url_components['path'].'?'.$url_components['query'].'&inicio='.$inicio;
            }
        }
        else {
            $url = $url_components['path'].'?inicio='.$inicio;
        }
        return $url;
    }
    
    private function is_current($inicio) {
        $url_components = parse_url($_SERVER['REQUEST_URI']);
        if (isset($url_components['query'])) {
            if (preg_match('/inicio=/', $url_components['query'])) {
                if (preg_match('/inicio='.$inicio.'/', $url_components['query'])) {
                    return TRUE;
                }
            }
            elseif ($inicio == 0) {
                return TRUE;
            }
        }
        elseif ($inicio == 0) {
            return TRUE;
        }
        return FALSE;
    }
    
}
?>