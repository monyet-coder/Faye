<?php
	App::load()->lib('HTML');

	class UITextArea extends textarea {
		public function __construct($attr = array(), $value = NULL) {
			parent::__construct($attr);
			
			if($value !== NULL) {
				$this->append($value);
			}			
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}		
	}