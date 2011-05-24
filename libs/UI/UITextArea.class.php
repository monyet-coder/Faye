<?php
	App::load()->lib('HTML');

	class UITextArea extends textarea {
		public function __construct($attr = array(), $value = NULL) {
			parent::__construct($attr);
			
			if($value !== NULL) {
				$this->append($value);
			}			
		}
	}