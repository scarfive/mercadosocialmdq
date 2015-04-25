<?php
    /**
     * Clase ImageHandler
     *
     * @author Juan Manuel Scarciofolo
     * @license http://www.gnu.org/copyleft/gpl.html
     * @since 22/12/2014
     */
    class ImageHandler {
        
        private $path = 'uploads/';
        private $names = NULL;

        public function __construct() {
            $this->names = array();
        }
        
        public function loadImages() {
            if (!isset($_FILES["imagenes"])) {
                return FALSE;
            }
            for ($index = 0; $index < 3; $index++) {
                $name = '';
                if (is_uploaded_file($_FILES["imagenes"]["tmp_name"][$index])) {
                    $new_name = $this->path . $this->getPrefix() . $_FILES["imagenes"]["name"][$index];
                    if (copy($_FILES["imagenes"]["tmp_name"][$index], $new_name)) {
                        $name = $new_name;
                        $resize = new ImageResize($name);
                        $resize->resize();
                    }
                }
                $this->names[] = $name;
            }
            if (sizeof($this->names) < 1) {
                return FALSE;
            }
            return TRUE;
        }
        
        public function getImagePath() {
            return $this->path;
        }
        
        public function getImageNames() {
            return $this->names;
        }
        
        public function getPrefix() {
            return time().'-';
        }
        
    }
?>