<?php
	App::load()->lib('HTML');
	App::load()->lib('iUIOption', '/UI');

	class UIComboBox extends select implements iUIOption {
		public function __construct($options, $attr = array()) {
			parent::__construct($attr);
			$this->addClass('UI UI-Combo-Box');
			
			foreach($options as $value => $text) {
				$this->append(
					HTML('option', array('value' => $value))->append($text)
				);
			}
		}
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			
			return parent::render();
		}
	}