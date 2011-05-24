<?php
	App::load()->lib('HTML');

	class UIPopup extends UIList {
		public function render() {
			View::getInstance()->addScript('UI/UIPopup.js');
			
			return parent::render();
		}
	}