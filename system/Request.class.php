<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	final class Request extends Singleton {
		protected static $instance;
		
		const GET 		= 'GET';
		const PUT 		= 'PUT';
		const POST 		= 'POST';
		const DELETE	= 'DELETE';
		
		public function time() {
			return $_SERVER['REQUEST_TIME'];
		}
		
		public function referer() {
			return $_SERVER['HTTP_REFERER'];
		}
		
		public function isAJAX() {
			return 
				isset($_SERVER['HTTP_X_REQUESTED_WITH']) and 
				strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
		}

		public function clientIP() {
			return $_SERVER['REMOTE_ADDR'];
		}

		public function is($type) {
			$type = ucfirst(strtolower($type));
			$method = 'is' . $type;
			
			if(is_callable(array($this, $method))) {
				return $this->{$method}();
			}
			
			trigger_error('The method specified isn\'t recognized.', E_USER_ERROR);
		}
		
		public function isGet() {
			return $_SERVER['REQUEST_METHOD'] === self::GET;
		}
		
		public function isPut() {
			return $_SERVER['REQUEST_METHOD'] === self::PUT;
		}		
		
		public function isPost() {
			return $_SERVER['REQUEST_METHOD'] === self::POST;
		}		
		
		public function isDelete() {
			return $_SERVER['REQUEST_METHOD'] === self::DELETE;
		}
	}