<?php
	class ColumnModel {
		public $names 	= array();
		public $types	= array();
		public $lengths = array();
		
		public function add($name, $type, $len) {
			$this->names[] = $name;
			$this->types[] = $type;
			$This->lengths[] = $len;
		}
		
		public function name($key) {
			if(is_string($key) and ($index = array_search($key, $this->names)) !== false) {
				$key = $index;
			}
			
			return $this->names[$key];
		}
		
		public function type($key) {
			if(is_string($key) and ($index = array_search($key, $this->names)) !== false) {
				$key = $index;
			}
			
			return $this->types[$key];
		}
		
		public function len($key) {
			if(is_string($key) and ($index = array_search($key, $this->names)) !== false) {
				$key = $index;
			}
			
			return $this->lengths[$key];
		}
	}