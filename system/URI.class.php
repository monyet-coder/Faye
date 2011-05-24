<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	final class URI extends Singleton {
		protected static $instance;
		
		private $route;
		private $reroute;
		private $segments;
		private $rsegments;
		private $extension;
		private $query = array();
		
		protected function __construct($route, $reroute) {
			App::load()->config('reroute');

			$this->extension = pathinfo($reroute, PATHINFO_EXTENSION);

			$arr = array('route' => $route, 'reroute' => $reroute);
			foreach($arr as $key => $URI) {
				if(strrpos($URI, '.' . $this->extension) === strlen($URI) - strlen($this->extension) - 1) {
					$arr[$key] = str_replace('.' . $this->extension, NULL, $URI);
				}
			}

			$this->route = $arr['route'];
			$this->reroute = $arr['reroute'];
			$this->segments = explode('/', $this->route);
			$this->rsegments = explode('/', $this->reroute);
						
			$len = count($this->rsegments);
			for($i = $len % 2 === 0 ? 2 : 1; $i < $len - 1; $i += 2) {
				$this->query[$this->rsegments[$i]] = $this->rsegments[$i + 1];
			}
		}
		
		public static function getInstance($route = '', $reroute = '') {
			if(empty(self::$instance)) {
				self::$instance = new self($route, $reroute);
			}
			
			return self::$instance;
		}
		
		public function segment($n) {
			$n = $n < 0 ? count($this->segments) + $n : $n;
			
			return isset($this->segments[$n]) ? $this->segments[$n] : NULL;
		}
		
		public function rsegment($n) {
			$n = $n < 0 ? count($this->rsegments) + $n : $n;
			
			return isset($this->rsegments[$n]) ? $this->rsegments[$n] : NULL;
		}
		
		public function __get($key) {
			switch($key) {
				case 'segment':
				case 'rsegment':
				case 'query':
					return $this->{$key};
			}
		}
		
		public function __toString() {
			return $this->route;
		}
	}	