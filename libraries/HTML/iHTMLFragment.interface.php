<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
    
    interface iHTMLFragment extends iXMLFragment {
        public function addClass($className);
        public function removeClass($className);
        public function toggleClass($className);
        public function setData($key, $value);
    }