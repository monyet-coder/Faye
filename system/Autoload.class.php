<?php
	class Autoload extends Singleton {
		protected static $instance;
		
		public $paths = array();
		
		public function register($path) {
			if(is_dir($path)) {
				$this->paths[] = rtrim($path, '/');
			}
			
			return $this;
		}
		
		public function unregister($path) {
			$flip = array_flip($this->paths);
			if(isset($flip[$path])) {
				unset($this->paths[$flip[$path]]);
			}
			
			return $this;
		}
	}

	$autoload = Autoload::getInstance();
	
	$autoload->register(__SITE_PATH . '/' . __APPLICATION_PATH . '/' . __MODEL_PATH);
	$autoload->register(__SITE_PATH . '/' . __LIBRARY_PATH . '/UI');

	function __autoload($className) {
		foreach(Autoload::getInstance()->paths as $path) {
			$fileName = $path . '/' . $className . '.class.php';
			
			if(is_file($fileName)) {
				include $fileName;
			}
		}
	}