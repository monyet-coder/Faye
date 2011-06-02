<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UILink extends a {
		public function __construct($href, $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-Link')->setAttr('href', $href);
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
	}