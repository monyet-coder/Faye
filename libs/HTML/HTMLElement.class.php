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
				$this->attr['class'] = '';
			}
			
			if(!$this->hasClass($className)) {
				$this->attr['class'] .= $className . ' ';
			}
			
			return $this;
		}
		
		public function removeClass($className) {
			if($this->hasClass($className)) {
				$this->attr['class'] = str_replace($className, (string)NULL, $this->attr['class']);
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
		
		public function val($value = NULL) {
			if($value === NULL) {
				return $this->hasAttr('value') ? $this->attr('value') : NULL;
			} else {
				$this->setAttr('value', $value);
				
				return $value;
			}			
		}
		
		public function show() {
			return $this->removeClass('Hide');
		}
		
		public function hide() {
			return $this->addClass('Hide');
		}
	}