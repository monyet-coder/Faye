<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class UserAgent extends Singleton {
		protected static $instance;
		
		private $agent;
	
		private $browsers;
		private $OSList;
		private $engines;
	
		private $isBrowser	= FALSE;
		private $isMobile	= FALSE;		
	
		private $OS;
		private $browser;
		private $version;
		private $engine;
		private $series;
		
		protected function __construct() {
			if(isset($_SERVER['HTTP_USER_AGENT'])) {
				$this->agent = trim($_SERVER['HTTP_USER_AGENT']);
			}
			
			if(!empty($this->agent)) {
				App::load()->config('userAgent');
				
				$this->OSList = Config::getInstance()->userAgent['OS'];
				$this->browsers = Config::getInstance()->userAgent['browsers'];				
				$this->engines = Config::getInstance()->userAgent['engines'];
			}
		}
		
		private function setBrowser() {
			foreach((array)$this->browsers as $key => $val) {
				if(preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $this->agent, $match)) {
					$this->isBrowser = true;
					$this->version = $match[1];
					$this->browser = $val;
					
					return true;
				}
			}
			
			return false;
		}
		
		private function setEngine() {
			foreach((array)$this->engines as $key => $val) {
				if(preg_match('|' . preg_quote($key) . '\/([0-9\.]+)|i', $this->agent, $match)) {					
					$this->engine = $key;
					$this->series = $match[1];
					
					return true;
				}				
			}
			
			return false;
		}
		
		private function setOS() {
			foreach((array)$this->OSList as $key => $val) {
				if (preg_match("|".preg_quote($key)."|i", $this->agent)) {
					$this->OS = $val;
					return TRUE;
				}
			}
			
			return false;
		}
		
		public function getBrowser() {
			if(empty($this->browser)) {
				$this->setBrowser();
			}
			
			return $this->browser;
		}
		
		public function getVersion() {
			if(empty($this->browser)) {
				$this->setBrowser();
			}
			
			return $this->version;
		}
		
		public function getOS() {
			if(empty($this->OS)) {
				$this->setOS();
			}
			
			return $this->OS;
		}
		
		public function getEngine() {
			if(empty($this->engine)) {
				$this->setEngine();
			}
			
			return $this->engine;
		}
		
		public function getSeries() {
			if(empty($this->series)) {
				$this->setEngine();
			}
			
			return $this->series;
		}		
		
		public function __toString() {
			return (string)$this->agent;
		}
	}