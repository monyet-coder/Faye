<?php
	App::load()->lib('HTML');
	App::load()->lib('iUIMultipleOption', '/UI');
	
	class UITextField extends input {
		public $ghostText = NULL;
		
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->setAttr('type', 'text');
			$this->addClass('UI UI-Text-Field');
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
		
		protected function getScripts() {
			return array_merge(parent::getScripts(), array(
				'UI/UITextField.js',
			));
		}
		
		public function render() {
			if($this->ghostText !== NULL) {
				$this->addClass('Ghost-Text');
				$this->__set('value', $this->ghostText);
			}
			
			return parent::render();
		}
	}