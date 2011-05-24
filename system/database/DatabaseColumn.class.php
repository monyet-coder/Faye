<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class DatabaseColumn implements ArrayAccess {
		protected $columns = array();
		
		protected $names 	= array();
		protected $types	= array();
		protected $lengths = array();
		
		public function add($name, $type, $length) {
			$this->columns[] = array(
				'name' => $name,
				'type' => $type,
				'length' => $length,
			);
		}
		
		public function getNames() {
			if(empty($this->names)) {
				foreach($this->columns as $index => $column) {
					$this->names[] = $column['name'];
				}
			}
			
			return $this->names;
		}
		
		public function getTypes() {
			if(empty($this->types)) {
				foreach($this->columns as $index => $column) {
					$this->types[] = $column['type'];
				}
			}
			
			return $this->types;
		}
		
		public function getLengths() {
			if(empty($this->lengths)) {
				foreach($this->columns as $index => $column) {
					$this->lengths[] = $column['length'];
				}
			}
			
			return $this->lengths;
		}
		
		private function toIndex($key) {
			if(is_string($key) and ($index = $this->toIndex($key) !== false)) {
				$key = $index;
			}
			
			return $key;
		}
		
		public function getName($key) {						
			return $this->columns[$this->toIndex($key)]['name'];
		}
		
		public function getType($key) {			
			return $this->columns[$this->toIndex($key)]['type'];
		}
		
		public function getLength($key) {			
			return $this->columns[$this->toIndex($key)]['length'];
		}
		
		public function offsetExists($offset) {
			return isset($this->columns[$offset]);
		}
		
		public function offsetUnset($offset) {
			unset($this->columns[$offset]);
		}
		
		public function offsetGet($offset) {
			return (array)$this->__get($offset);
		}
		
		public function offsetSet($offset, $value) {
			throw new Exception('The column property is read only.');
		}
		
		public function __get($key) {			
			return (object)$this->columns[$this->toIndex($key)];
		}
	}