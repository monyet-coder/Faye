<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Stack implements Countable, IteratorAggregate {
		protected $stack = array();
		
		public function __construct($coll = array()) {
			$this->stack = $coll;
		}
		
		public function push() {
			$this->stack = array_merge($this->stack, func_get_args());
			
			return $this;
		}
		
		public function pop() {
			if($this->count() === 0) {
				throw new Exception('The stack is empty.');
			}
						
			return array_pop($this->stack);
		}
		
		public function peek() {
			if($this->count() === 0) {
				throw new Exception('The stack is empty.');
			}
			
			return $this->stack[$this->count() - 1];
		}
		
		public function getIterator() {
			return new ArrayIterator($this->stack);
		}
		
		public function count() {
			return count($this->stack);
		}
	}