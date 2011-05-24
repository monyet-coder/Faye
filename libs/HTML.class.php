<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->lib('XML');
	App::load()->lib('XMLNode', '/XML');
	App::load()->lib('HTMLElement', '/HTML');
	App::load()->lib('HTMLElements', '/HTML');

	class HTML extends XML {
		protected static $instance;
		
		public function __invoke($tagName, $attr = array()) {
			$tagName = trim($tagName);
			
			if(class_exists($tagName)) {
				return new $tagName($attr);
			}
			
			return new HTMLElement($tagName, $attr);
		}
	}
	
	function HTML($tagName, $attr = array()) {
		return HTML::getInstance()->__invoke($tagName, $attr);
	}