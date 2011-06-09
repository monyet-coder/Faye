<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
    
    class XMLFragment implements iXMLFragment, IteratorAggregate {
        public function __construct($children = array()) {
            $this->children = $children;
        }
        
        public function dissolve() {
            return $this->children;
        }
        
        public function fill() {
            foreach(func_get_args() as $argument) {
                if(is_array($argument)) {
                    foreach($argument as $arg) {
                        $this->fill($arg);
                    }
                } else {
                    $this->children[] = $argument;
                }                
            }
            
            return $this;
        }
        
        protected function apply($methodName, $args) {
            switch(count($args)) {
                case 0:
                    foreach($this->children as $child) {
                        $child->{$methodName}();
                    }
                break;
                case 1:
                    foreach($this->children as $child) {
                        $child->{$methodName}($args[0]);
                    }
                break;
                case 2:
                    foreach($this->children as $child) {
                        $child->{$methodName}($args[0], $args[1]);
                    }                    
                break;
                case 3:
                    foreach($this->children as $child) {
                        $child->{$methodName}($args[0], $args[1], $args[2]);
                    }                
                break;
                default:
                    foreach($this->children as $child) {
                        call_user_func_array(array($child, $methodName), $args);
                    }                
                break;                
            }
            
            return $this;
        }
        
        public function clearChildren() {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function attr($attrName, $attrValue = NULL) {
            return $this->apply(__FUNCTION__, func_get_args());
        }       
        
        public function clearAttr() {
            return $this->apply(__FUNCTION__, array());
        }
        
        public function setAttr($attrName, $attrValue = NULL) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function removeAttr($attrName) {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function prepend() {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function append() {
            return $this->apply(__FUNCTION__, func_get_args());
        }
        
        public function appendTo(XMLNode $parent) {
            return $this->apply(__FUNCTION__, array($parent));
        }
        
        public function prependTo(XMLNode $parent) {
            return $this->apply(__FUNCTION__, array($parent));
        }
        
        public function get($index) {
            $count = count($this->children);
            
            return $this->children[($count + $index % $count) % $count];
        }
        
        public function count() {
            return count($this->children);
        }
        
        public function getIterator() {
            return new ArrayIterator($this->children);
        }
        
        public function offsetExists($offset) {
            return isset($this->children[$offset]);
        }
        
        public function offsetUnset($offset) {
            unset($this->children[$offset]);
        }
        
        public function offsetGet($offset) {
            return $this->get($offset);
        }
        
        public function offsetSet($offset, $node) {
            $this->children[$offset] = $node;
        }
        
        public function render() {
            return implode($this->children);
        }
        
        public function __toString() {
            return $this->render();
        }
    }