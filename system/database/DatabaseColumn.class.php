<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class DatabaseColumn implements ArrayAccess {
		protected $columns = array();
		protected $names 	= array();
		protected $types	= array();
		protected $lengths = array();
		
        /**
         *
         * @param type $type
         * @return string 
         */
		protected function normalize($type) {
			$type = strtolower($type);
			
			switch($type) {
				case 'int':
				case 'long':
				case 'short':
				case 'int24':
				case 'longlong':	
					$type = 'int';
				break;
				case 'varchar':
				case 'string':
				case 'var_string':
					$type = 'string';
				break;
				case 'blob':
				case 'text':
					$type = 'blob';
				break;
				case 'float':
				case 'real':
					$type = 'float';
				break;
				case 'decimal':
				case 'numeric':
				case 'newdecimal':
					$type = 'decimal';
				break;
			}
			
			return $type;
		}
		/**
         *
         * @param type $name
         * @param type $type
         * @param type $length
         * @return DatabaseColumn 
         */
		public function add($name, $type, $length) {
			$this->columns[] = array(
				'name' => $name,
				'type' => $this->normalize($type),
				'length' => $length,
			);
            
            return $this;
		}
		/**
         *
         * @return array
         */
		public function getNames() {
			if(empty($this->names)) {
				foreach($this->columns as $index => $column) {
					$this->names[] = $column['name'];
				}
			}
			
			return $this->names;
		}
		/**
         *
         * @return array
         */
		public function getTypes() {
			if(empty($this->types)) {
				foreach($this->columns as $index => $column) {
					$this->types[$column['name']] = $column['type'];
				}
			}
            
			return $this->types;
		}
		/**
         *
         * @return array 
         */
		public function getLengths() {
			if(empty($this->lengths)) {
				foreach($this->columns as $index => $column) {
					$this->lengths[$column['name']] = $column['length'];
				}
			}
			
			return $this->lengths;
		}
		/**
         *
         * @param string $key
         * @return string 
         */
		private function toIndex($key) {
			if(is_string($key) and ($index = array_search($key, $this->getNames())) !== false) {
				$key = $index;
			}

			return $key;
		}
		/**
         *
         * @param int $key
         * @return string 
         */
		public function getName($key) {
			return $this->columns[$key]['name'];
		}
		/**
         *
         * @param int, string $key
         * @return string 
         */
		public function getType($key) {
			return $this->columns[$this->toIndex($key)]['type'];
		}
		/**
         *
         * @param int, string $key
         * @return int 
         */
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