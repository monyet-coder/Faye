<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
    
    App::loader()->lib('XMLFragment', 'XML');
    
    class HTMLFragment extends XMLFragment {        
        public function addClass($className) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function removeClass($className) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function toggleClass($className) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function setData($key, $value) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function val($value = NULL) {            
            foreach($this->children as $child) {
                if($child instanceof inputElement) {
                    if($value === NULL) {
                        return $child->val();
                    } else {
                        $child->val($value);
                    }
                }
            }
            
            return $this;
        }
    }