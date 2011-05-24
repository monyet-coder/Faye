<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	final class Config extends Singleton {
		protected static $instance;
		private $config = array();
		
		protected function __construct() {
			$this->load('config');
		}
		
		public function load() {
			foreach(func_get_args() as $arg) {
				$fileName = __SITE_PATH . '/' . __CONFIG_PATH . '/' . $arg . '.php';

				if(is_file($fileName)) {
					$config = array();
					
					include $fileName;
					
					$this->config = $this->config + (array)$config;
				} else {
					trigger_error('Config file for inclusion can\'t be found.');
				}
			}
		}
		
		public function __get($key) {
			return $this->config[$key];
		}
	}