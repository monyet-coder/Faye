<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	abstract class Controller {
		protected $URI = NULL;
		protected $view = NULL;
		protected $load = NULL;
		protected $config = NULL;
		protected $request = NULL;	
		protected $response = NULL;
		
		public function __construct() {
			$this->URI = URI::getInstance();
			$this->view = View::getInstance();
			$this->load = Loader::getInstance();
			$this->config = Config::getInstance();
			$this->request = Request::getInstance();
			$this->response = Response::getInstance();
		}
		
		public static function exists($controllerName) {
			return is_file(__SITE_PATH . '/' . __APPLICATION_PATH . '/' . __CONTROLLER_PATH . '/' . $controllerName . '.controller.php');
		}
	}