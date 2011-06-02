<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UIUpload extends input {
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->setAttr('type', 'file');
		}
	}