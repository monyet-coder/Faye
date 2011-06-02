<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Autoload extends Singleton {
		protected static $instance;
		
		public $paths = array();
		
		public static function register($path) {
			$_this = self::getInstance();
			if(is_dir($path)) {
				$_this->paths[] = __SITE_PATH . '/' . trim($path, '/');
			}
			
			return $_this;
		}
		
		public static function unregister($path) {
			$_this = self::getInstance();
			$flip = array_flip($_this->paths);
			if(isset($flip[$path])) {
				unset($_this->paths[$flip[$path]]);
			}
			
			return $_this;
		}
	}

	function __autoload($className) {
		foreach(Autoload::getInstance()->paths as $path) {
			$fileName = $path . '/' . $className . '.class.php';

			if(is_file($fileName)) {
				require $fileName;
                
                return true;
			}
		}
        
        return false;
	}