<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Queue implements Countable, IteratorAggregate {
		protected $stack = array();
		
		public function __construct($coll = array()) {
			$this->queue = $coll;
		}
		
		public function push() {
			$this->queue = array_merge($this->queue, func_get_args());
			
			return $this;
		}
		
		public function pop() {
			if($this->count() === 0) {
				throw new Exception('The queue is empty.');
			}
						
			return array_shift($this->queue);
		}
		
		public function peek() {
			if($this->count() === 0) {
				throw new Exception('The queue is empty.');
			}
			
			return $this->queue[$this->count() - 1];
		}
		
		public function getIterator() {
			return new ArrayIterator($this->queue);
		}
		
		public function count() {
			return count($this->queue);
		}
	}