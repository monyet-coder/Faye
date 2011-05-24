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
		
		public function render() {
			View::getInstance()
				->addStyle('UI/UI.css')
				->addScript('UI/UITextField.js');
				
			if($this->ghostText !== NULL) {
				$this->addClass('Ghost-Text');
				$this->__set('value', $this->ghostText);
			}
			
			return parent::render();
		}
	}