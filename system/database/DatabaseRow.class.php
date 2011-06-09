<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class DatabaseRow implements ArrayAccess {
		public $cells = array();
		
		public function __construct($cells) {
			$this->cells = $cells;
		}
		
		public function offsetExists($name) {
			return $this->__get($name) === NULL;
		}
		
		public function offsetUnset($name){}
		
		public function offsetGet($name) {
			return $this->__get($name);
		}
		
		public function offsetSet($name, $value) {
			$this->__set($name, $value);
		}
		
		public function __set($key, $value) {
			$this->cells[$key] = $value;
		}
		
		public function __get($key) {			
			return isset($this->cells[$key]) ? $this->cells[$key] : NULL;
		}
	}