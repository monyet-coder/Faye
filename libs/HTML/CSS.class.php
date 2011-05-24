<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class CSSStyleProperty {
		const MATCH_NUMBER = '/(\w|-)+[ ]+([px|em|%]?)/i';
		
		public $name;
		public $value = array();
		
		public function __construct($name, $values) {
			$this->name = $name;
			
			if(is_string($values)) {
				$values = explode(' ', $values);
			}
			
			$this->value = array_map(array($this, 'transformValue'), $values);
		}
		
		protected function transformValue($value) {
			$value = trim($value);
			
			if(is_numeric($value)) {
				$value .= 'px ';
			}
			
			return $value;
		}
		
		public function __toString() {
			return sprintf("\t%s: %s;\n", $this->name, implode(' ', $this->value));
		}
	}

	class CSSStyle {
		protected $selector;
		protected $props = array();
		
		public function __construct($selector) {
			$this->selector = $selector;
		}
		
		public function __call($propName, $propValues) {
			$this->__set($propName, implode(' ', $propValues));
			
			return $this;
		}
		
		public function __get($propName) {
			return $this->props[$propName];
		}
		
		public function __set($propName, $propVal) {
			$newProp = new CSSStyleProperty($propName, $propVal);
			
			$this->props[] = $newProp;
		}
		
		public function render() {			
			return sprintf("%s {\n%s}\n\n", $this->selector, implode($this->props));
		}
		
		public function __toString() {
			return $this->render();
		}
	}

	class CSS extends Singleton {		
		const COLOR_WHITE 			= '#FFF';
		const COLOR_BLACK 			= '#000';
		const COLOR_BLUE			= '#00F';
		const COLOR_GREEN			= '#0F0';
		const COLOR_RED				= '#F00';
		const COLOR_GREY			= '#666';
		
		const PADDING_SMALL		= '2px';
		const PADDING_MEDIUM		= '6px';
		const PADDING_LARGE		= '12px';
		
		const POSITION_ABSOLUTE	= 'absolute';
		const POSITION_STATIC		= 'static';
		const POSITION_FIXED		= 'fixed';
		
		protected static $styles 	= array();
		protected static $instance	= NULL;
		
		public static function URL($URL) {
			return sprintf("url('%s')", $URL);
		}
		
		public function __invoke($selector) {
			return $this->create($selector);
		}
		
		public function create($selector) {
			if(isset(self::$styles[$selector])) {
				$style = self::$styles[$selector];
			} else {
				$style = new CSSStyle($selector);
				
				self::$styles[$selector] = $style;
			}
			
			return $style;
		}
		
		public static function inject() {
			$styleTag = HTML('style');
			foreach(self::$styles as $style) {
				$styleTag->append($style);
			}
			
			View::getInstance()->INLINE_STYLE = $styleTag;
			
			return CSS::getInstance();
		}
	}
	
	function CSS($selector = NULL) {
		if(empty($selector)) {
			return CSS::getInstance();
		}
		
		return CSS::getInstance()->create($selector);
	}