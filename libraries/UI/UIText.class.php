<?php
	App::load()->lib('HTML');

	class UIText extends span {
		public function __construct($text = '', $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-Text');
			$this->append($text);
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
		
		protected function getScripts() {
			return array_merge(parent::getScripts(), array(
				'UI/UINotification.js',
			));
		}
	}