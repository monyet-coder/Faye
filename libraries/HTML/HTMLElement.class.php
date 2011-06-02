<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class HTMLElement extends XMLNode {
		protected function addChild($child, $type) {									
			if(!$this->isSingleton) {
				parent::addChild($child, $type);
			}
			
			return $this;
		}
		/**
         *
         * @param string $className
         * @return boolean
         */
		public function hasClass($className) {
			return 
				$this->hasAttr('class') and 
				in_array($className, explode(' ', $this->attr('class')));
		}
		/**
         *
         * @param string $className
         * @return HTMLElement 
         */
		public function addClass($className) {
            if(!$this->hasAttr('class')) {
                $this->setAttr('class', $className);
            } else if(!$this->hasClass($className)) {
				$this->setAttr('class', $this->attr('class') . ' ' . $className);
			}
			
			return $this;
		}
		/**
         *
         * @param string $className
         * @return HTMLElement 
         */
		public function removeClass($className) {
			if($this->hasClass($className)) {
				$this->setAttr('class', str_replace($className, NULL, $this->attr('class')));
			}
			
			return $this;
		}
		/**
         *
         * @param string $className
         * @return HTMLElement 
         */
		public function toggleClass($className) {
			if($this->hasClass($className)) {
				$this->removeClass($className);
			} else {
				$this->addClass($className);
			}
			
			return $this;
		}
		/**
         *
         * @param string $key
         * @param mixed $value
         * @return HTMLElement 
         */
        public function setData($key, $value) {
            $this->setAttr('data-' . $key, $value);
            
            return $this;
        }
        /**
         *
         * @param string $key
         * @return mixed
         */
        public function getData($key) {
            return $this->attr('data-' . $key);
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