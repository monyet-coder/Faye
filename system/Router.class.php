<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class Router extends Singleton {
		private $class;
		private $method;
		private $controller;
		private $URI;
		
		private $wildcards = array(
			'/'		=> '\/',
			':any' 	=> '([\w]+)',
			':num' 	=> '([0-9]+)',
		);
		
		protected function __construct() {
			$route = isset($_GET['rt']) ? $_GET['rt'] : '';
			$reroute = $this->reroute($route);
			
			$this->URI = URI::getInstance($route, $reroute);
		}
	
		private function reroute($route) {
			Config::getInstance()->load('reroute');
			
			$reroutePath = Config::getInstance()->reroute;
			foreach($reroutePath as $pattern => $replace) {				
				$pattern = sprintf('/%s/', str_replace(array_keys($this->wildcards), $this->wildcards, $pattern));
				
				if(preg_match($pattern, $route)) {
					return preg_replace($pattern, $replace, $route);
				}
			}
			
			return $route;
		}
	
		public function run() {
			App::load()->util('String');
			
			$this->class 	= String::pascalize(URI::getInstance()->rsegment(0));
			$this->method 	= String::camelize(URI::getInstance()->rsegment(1));
			
			if(empty($this->class)) {
				$this->class = 'Index';
			}
			if(!Controller::exists($this->class)) {
				Response::getInstance()->setHTTPCode(Response::NOT_FOUND);
				echo
					HTML('h1')->append(
						'Page not found'
					), 
					HTML('p')->append(
						'Please check your URL, ',
						HTML('strong')->append(
							App::basePath(URI::getInstance())
						)
					);
				
				return false;
			}
			
			App::load()->controller($this->class);
			
			$className = $this->class . 'Controller';
			$this->controller = new $className;
			
			if(!is_callable(array($this->controller, $this->method))) {
				$this->method = 'index';
			}
			
			call_user_func_array(array($this->controller, $this->method), (array)URI::getInstance()->query);
			
			return true;
		}
	}