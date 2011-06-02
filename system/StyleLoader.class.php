<?php
	App::load()->lib('HTML');	

	class StyleLoader {
		private $styles = array();
		
		public function __construct() {
			
		}
		
		public function exists($styleName) {	
			$flip = array_flip($this->styles);
			
			return isset($flip[$styleName]) ? $flip[$styleName] : false;
		}		
		
		public function add($styleName) {			
			if(!$this->exists($styleName)) {			
				$this->styles[] = $styleName;
			}
			
			return $this;
		}
		
		public function remove($styleName) {
			if(($key = $this->exists($styleName)) !== false) {
				unset($this->styles[$key]);
			}
			
			return $this;
		}
		
		public function __toString() {
			$styles = array();
			foreach($this->styles as $styleName) {
				if(strpos('http://', $styleName) === 0) {
					$styles[] = HTML('link', array('href' => $styleName));
				} else {
					$styles[] = HTML('link', array('href' => __BASE_PATH . __RESOURCE_PATH . '/' . __STYLE_PATH . '/' . $styleName));
				}
			}
			
			return implode("\n", $styles);
		}
	}