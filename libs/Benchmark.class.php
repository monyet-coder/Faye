<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Benchmark extends Singleton {
		protected static $instance;
		private $marks = array();
		
		protected function __construct() {			
			$this->mark('APPLICATION_BENCHMARK');
		}
		
		public function memory() {
			return memory_get_usage(true);
		}
		
		public function peak() {
			return memory_get_peak_usage(true);
		}
		
		public function started($name) {
			return isset($this->marks[$name]['start']);
		}
		
		public function start($name) {
			$this->marks[$name]['start'] = microtime(true);
			
			return $this;
		}
		
		public function end($name) {
			$this->marks[$name]['end'] = microtime(true);
			
			return $this;
		}
		
		public function elapsed($name) {
			if(!isset($this->marks[$name]['end'])) {
				$this->end($name);
			}
			
			return $this->marks[$name]['end'] - $this->marks[$name]['start'];
		}
		
		public function getKeys() {
			return array_keys($this->marks);
		}
		
		public function getMarks() {
			$marks = array();
			foreach($this->marks as $name => $mark) {
				$marks[$name] = $mark['elapsed'];
			}
			
			return $marks;
		}
		
		public function mark() {
			$names = func_get_args();

			foreach($names as $name) {				
				if(!$this->started($name)) {
					$this->start($name);
				} else {
					$this->end($name);
				}
			}
			
			return count($names) == 1 ? $this->elapsed($names[0]) : $this;
		}
		
		public function __invoke() {			
			return call_user_func_array(array($this, 'mark'), func_get_args());
		}
		
		public function __get($name) {			
			return $this->elapsed($name);
		}
		
		public function __toString() {
			$this->end('APPLICATION_BENCHMARK');
			
			return (string)$this->elapsed('APPLICATION_BENCHMARK');
		}
	}