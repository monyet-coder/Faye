<?php
	App::load()->lib('HTML');	

	class ScriptLoader {
		private $scripts = array();
		
		public function __construct() {
			
		}
		
		public function exists($scriptName) {
			$flip = array_flip($this->scripts);
			
			return isset($flip[$scriptName]) ? $flip[$scriptName] : false;
		}
		
		public function add($scriptName) {
			if(!$this->exists($scriptName)) {				
				$this->scripts[] = $scriptName;
			}
			
			return $this;
		}
		
		public function remove($scriptName) {
			if(($key = $this->exists($scriptName)) !== false) {
				unset($this->scripts[$key]);
			}
			
			return $this;
		}
		
		public function __toString() {
			$scripts = array();
			foreach($this->scripts as $scriptName) {
				if(strpos('http://', $scriptName) === 0) {
					$scripts[] = HTML('script', array('src' => $scriptName));
				} else {
					$scripts[] = HTML('script', array('src' => __BASE_PATH . __RESOURCE_PATH . '/' . __SCRIPT_PATH . '/' . $scriptName));
				}
			}
			
			return implode("\n", $scripts);
		}
	}