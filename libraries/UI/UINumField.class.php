<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UINumField extends UITextField {
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI-Num-Field');
		}
	}