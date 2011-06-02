<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Session extends Singleton implements ArrayAccess, Countable, IteratorAggregate {
		protected static $instance;
		
		protected $__SESSION = array();
		
		protected function __construct() {
			session_start();
			
			$this->__SESSION = $_SESSION;
			$_SESSION = $this;
		}
		
		public function __destruct() {
			$_SESSION = $this->__SESSION;
		}
		
		public function offsetExists($offset) {
			return isset($this->__SESSION[$offset]);
		}
		
		public function offsetUnset($offset) {
			unset($this->__SESSION[$offset]);
		}
		
		public function offsetSet($offset, $value) {
			if($offset === NULL) {
	            $this->__SESSION[] = $value;
	        } else {
	            $this->__SESSION[$offset] = $value;
	        }
		}
		
		public function offsetGet($offset) {
			return $this->__get($offset);
		}
		
		public function count() {
			return count($this->__SESSION);
		}
		
		public function getIterator() {
			return new ArrayIterator($this->__SESSION);
		}
		
		public function invalidate(){
			session_destroy();
			$this->__SESSION = array();
			
			return $this;
		}
		
		public function getId() {
			return session_id();
		}
		
		public function setId($id) {
			session_id($id);
			
			return $this;
		}
		
		public function getKeys() {
			return array_keys($this->__SESSION);
		}
		
		public function __get($name) {
			return $this->__SESSION[$name];
		}
		
		public function __set($name, $value) {
			$this->offsetSet($name, $value);
		}
	}