<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class Registry extends Singleton {
		protected static $instance;
		private $vars = array();
		
		public function __get($key) {
			return $this->vars[$key];
		}
		
		public function __set($key, $value) {
			$this->vars[$key] = $value;
		}
	}