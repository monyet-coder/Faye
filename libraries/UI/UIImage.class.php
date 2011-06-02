<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UIImage extends img {
		public function __construct($src, $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-Image')->setAttr('src', $src);
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
	}