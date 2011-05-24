<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Loader extends Singleton {		
		protected static $instance;		
		
		private $types 	= array();
		private $loaded = array();
		
		protected function __construct() {
			$this->types = array(
				'system' => array(
					'path' 	=> __SYSTEM_PATH, 
					'ext' 	=> '.class|.interface'
				),
				'config' => array(
					'path' 	=> __CONFIG_PATH, 
					'ext' 	=> NULL
				),
				'controller'=> array(
					'path' 	=> __APPLICATION_PATH . '/' . __CONTROLLER_PATH, 
					'ext'	=> '.controller'
				),
				'model'	=> array(
					'path' 	=> __APPLICATION_PATH . '/' . __MODEL_PATH, 
					'ext' 	=> '.class|.interface'
				),
				'view' => array(
					'path' 	=> __APPLICATION_PATH . '/' . __VIEW_PATH, 
					'ext' 	=> '.view'
				),
				'database' => array(
					'path' 	=> __SYSTEM_PATH . '/' . __DATABASE_PATH, 
					'ext' 	=> '.class|.interface'
				),
				'library' => array(
					'path' 	=> __LIBRARY_PATH, 
					'ext' 	=> '.class|.interface'
				),
				'utility' => array(
					'path'	=> __UTILITY_PATH,
					'ext'	=> '.class|.interface'
				),
			);
		}
		
		public function __invoke() {
			return $this;
		}
		
		private function load($name, $type, $subDir = '') {
			$path 	= $this->types[$type]['path'];
			$exts 	= $this->types[$type]['ext'];
			$found 	= false;
			
			$subDir = (!empty($subDir) and $subDir[0] === '/' ? NULL : '/') . $subDir;
			
			foreach(explode('|', $exts) as $ext) {
				$fileName = __SITE_PATH . '/' . $path . $subDir . '/' . $name . $ext . '.php';
				
				if(isset($this->loaded[$fileName])) {
					$found = true;
				} else if(is_file($fileName)) {
					include $fileName;
					
					$this->loaded[$fileName] = $found = true;	
				}
			}
			
			if(!$found) {
				throw new Exception($name . ' file not found or not readable for inclusion.');
			}
			
			return $this;
		}
		
		public function util($fileName, $subDir = '') {
			return $this->utility($fileName, $subDir);
		}
		
		public function utility($fileName, $subDir = '') {
			return $this->load($fileName, __FUNCTION__, $subDir);
		}
		
		public function lib($fileName, $subDir = '') {
			return $this->library($fileName, $subDir);
		}
		
		public function library($fileName, $subDir = '') {			
			return $this->load($fileName, __FUNCTION__, $subDir);
		}
		
		public function system($fileName, $subDir = '') {
			return $this->load($fileName, __FUNCTION__, $subDir);
		}
		
		public function config($fileName) {
			Config::getInstance()->load($fileName);
			
			return $this;
		}
		
		public function controller($fileName, $subDir = '') {
			return $this->load($fileName, __FUNCTION__, $subDir);
		}
		
		public function database($fileName, $subDir = '') {
			return $this->load($fileName, __FUNCTION__, $subDir);
		}
	}