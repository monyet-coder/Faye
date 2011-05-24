<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	define('this', 'this');
	
	class jQuery extends Singleton {
		const TACONITE_DRIVER	= 'Taconite';
		const NATIVE_DRIVER		= 'Native';
		
		const THIS				= this;
		
		protected static $instance;
		public $length 	= -1;
		public $onReady		= false;
		public $actions 		= array();
		public $driver			= NULL;
		public $driverName	= NULL;
		
		public function __invoke($selector = NULL) {
			if($selector === NULL) {
				return $this;
			}
			
			if($selector instanceof Closure) {
				return $this->ready($selector);
			}
			
			$this->actions[++$this->length] = array(
				'selector'	=> $selector,
				'chain'	=> array(),
			);
			
			return $this;
		}
		
		public function setDriver($driverName) {
			if(in_array($driverName, array(self::TACONITE_DRIVER, self::NATIVE_DRIVER))) {
				$this->driverName = $driverName = 'jQuery' . $driverName;
				
				App::load()->lib($this->driverName, '/jQuery');
				
				$this->driver = new $driverName($this);
			}
			
			return $this;
		}
		
		public function func() {			
			$args = func_get_args();
			$funcName = array_shift($args);
			
			$this->actions[$this->length]['chain'][] = array(
				'function' 	=> $funcName,
				'args'		=> $args,
			);
			
			return $this;
		}
		
		public function ready($callback) {
			$this->onReady = true;
			$callback();
			
			return $this;
		}
		
		public function getLength() {
			return $this->length;
		}
		
		public function addClass($className) {
			return $this->func(__FUNCTION__, $className);
		}
		
		public function removeClass($className) {
			return $this->func(__FUNCTION__, $className);
		}
		
		public function toggleClass($className) {
			return $this->func(__FUNCTION__, $className);
		}
		
		public function hasClass($className) {
			return $this->func(__FUNCTION__, $className);			
		}
		
		public function remove() {
			return $this->func(__FUNCTION__);
		} 
		
		public function append($content) {
			return $this->func(__FUNCTION__, $content);
		}
		
		public function prepend($content) {
			return $this->func(__FUNCTION__, $content);
		}
		
		public function css($propName, $propValue = NULL) {
			if(is_array($propName) and $propValue === NULL) {
				foreach($propName as $pName => $pValue) {
					$this->func(__FUNCTION__, $pName, $pValue);
				}
				
				return $this;
			}
			
			return $this->func(__FUNCTION__, $propName, $propValue);
		}
		
		public function show($duration = 0) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function hide($duration = 0) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function toggle($duration = 0) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function replace($content) {
			return $this->func(__FUNCTION__, $content);
		}
		
		public function replaceContent($content) {
			return $this->func(__FUNCTION__, $content);
		}
		
		public function attr($attrName, $attrValue = NULL) {
			if(is_array($attrName) and $attrValue === NULL) {
				foreach($attrName as $aName => $aValue) {
					$this->func(__FUNCTION__, $aName, $aValue);
				}
				
				return $this;
			}
			
			return $this->func(__FUNCTION__, $attrName, $attrValue);
		}
		
		public function fadeIn($duration = 400) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function fadeOut($duration = 400) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function slideDown($duration = 400) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function slideUp($duration = 400) {
			return $this->func(__FUNCTION__, $duration);
		}
		
		public function evaluate($command) {
			return $this->func('eval', $command);
		}
		
		public function click($callback) {
			return $this->func(__FUNCTION__, $callback);
		}
		
		public function reset() {
			$this->actions = array();
			
			return $this;
		}
		
		public function inject($varName = NULL) {
			$command = (string)$this->setDriver(self::NATIVE_DRIVER);
			
			if(Request::getInstance()->isAJAX()) {
				$this->reset();
				$this->setDriver(self::TACONITE_DRIVER);
				echo $this('head')->append($command);
			} else {
				View::getInstance()->__set($varName === NULL ? 'COMMAND' : $varName, $command);
			}
			
			return $this;
		}
		
		public function render() {
			return $this->driver->render($this->actions);
		}
		
		public function __toString() {
			return (string)$this->render();
		}
	}
	
	function jQuery($selector = NULL) {
		if($selector === NULL) {
			return jQuery::getInstance();
		}
		
		return jQuery::getInstance()->__invoke($selector);
	}