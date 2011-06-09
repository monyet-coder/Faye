<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class Singleton {
		protected static $instance;
		
		protected function __construct() {}		
		protected function __clone() {}
		
		public static function getInstance() {
			if(empty(static::$instance)) {
				static::$instance = new static;
			}
			
			return static::$instance;
		}
	}