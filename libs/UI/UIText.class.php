<?php
	App::load()->lib('HTML');

	class UIText extends span {
		public function __construct($text = '', $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-Text');
			$this->append($text);
		}
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			
			return parent::render();
		}
	}