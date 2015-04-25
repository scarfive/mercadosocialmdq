<?php

    class CampoCombo extends Campo {
        
        private $options = NULL;  /* array(id => value) */
        private $selected = NULL; /* array(id => is_selected) */

        public function __construct($name, $label = '') {
            parent::__construct($name, '', $label, '');
        }
        
        public function set_options($array_options) {
            $this->options = $array_options;
        }
        
        public function set_sql_options($result) {
            while ($row = mysql_fetch_array($result)) {
                $this->options[$row[0]] = $row[1];
                $this->selected[$row[0]] = FALSE;
            }
        }
        
        public function add_option($option, $index = 0) {
            $this->options[$index] = $option;
            $this->selected[$index] = FALSE;
        }
        
        public function append_option($option) {
            $this->options[] = $option;
            $this->selected[] = FALSE;
        }
        
        public function set_selected_option($option) {
            $this->selected[$option] = TRUE;
        }

        public function show() {
            print '<select name="'.parent::get_name().'" class="ui-campo ui-combo">';
            foreach ($this->options as $key => $value) {
                print '<option value="'.$key.'"'.($this->selected[$key] ? ' selected="selected"' : '').'>'.$value.'</option>';
            }
            print '</select>';
        }
        
    }

?>