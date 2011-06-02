<?php
	class HTMLElement extends XMLNode {
		protected function addChild($child, $type) {									
			if(!$this->isSingleton) {
				parent::addChild($child, $type);
			}
			
			return $this;
		}
		
		public function hasClass($className) {
			return 
				$this->hasAttr('class') and 
				in_array($className, explode(' ', $this->attr['class']));
		}
		
		public function addClass($className) {
			if(!$this->hasAttr('class')) {
				$this->setAttr('class', '');
			}
			
			if(!$this->hasClass($className)) {
				$this->setAttr('class', $this->attr('class') . $className);
			}
			
			return $this;
		}
		
		public function removeClass($className) {
			if($this->hasClass($className)) {
				$this->setAttr('class', str_replace($className, NULL, $this->attr('class')));
			}
			
			return $this;
		}
		
		public function toggleClass($className) {
			if($this->hasClass($className)) {
				$this->removeClass($className);
			} else {
				$this->addClass($className);
			}
			
			return $this;
		}
		
		protected function getScripts() {
			return array();
		}
		
		protected function getStyles() {
			return array();
		}
		
		public function render () {
			foreach($this->getScripts() as $script) {
				View::getInstance()->addScript($script);
			}
			
			foreach($this->getStyles() as $style) {
				View::getInstance()->addStyle($style);
			}
			
			return parent::render();
		}
	}