<?php
    /**
     * Clase ImageHandler
     *
     * @author Juan Manuel Scarciofolo
     * @license http://www.gnu.org/copyleft/gpl.html
     * @since 22/12/2014
     */
    class ImageHandler {
        
        private $field = 'imagen';
        private $count = 1;
        private $path = 'uploads/';
        private $names = NULL;

        public function __construct($field, $count = 1) {
            $this->field = $field;
            $this->count = $count;
            $this->names = array();
        }
        
        public function loadImages() {
            if (!isset($_FILES[$this->field])) {
                return FALSE;
            }
            for ($index = 0; $index < $this->count; $index++) {
                $name = '';
                if (is_uploaded_file($this->get_tmp_name($index))) {
                    $new_name = $this->get_new_name($index);
                    if (copy($this->get_tmp_name($index), $new_name)) {
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
        
        private function getPrefix() {
            return time().'-';
        }
        
        private function get_name($index = 0) {
            if ($this->count > 1) {
                return $_FILES[$this->field]["name"][$index];
            }
            return $_FILES[$this->field]["name"];
        }
        
        private function get_tmp_name($index = 0) {
            if ($this->count > 1) {
                return $_FILES[$this->field]["tmp_name"][$index];
            }
            return $_FILES[$this->field]["tmp_name"];
        }
        
        private function get_new_name($index = 0) {
            return $this->path . $this->getPrefix() . $this->get_name($index);
        }
        
    }
?>