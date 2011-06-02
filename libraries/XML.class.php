<?php
	App::load()->lib('XMLNode', '/XML');

	class XML extends Singleton {
		protected static $instance;
		
		const PSEUDO_TAG_EXPR = '/^<(.+)><\/(.+)>$/i';
		const SINGLETON_TAG_EXPR = '/<^(.+)[\/]?>$/i';
		
		public function __invoke($tagName, $attr) {
			if(preg_match(self::PSEUDO_TAG_EXPR, $tagName, $match) and $match[1] === $match[2]) {
				$markup = $match[0];
				$tagName = $match[1];
			} else if(preg_match(self::SINGLETON_TAG_EXPR, $tagName, $match)) {
				$markup = $match[0];
				$tagName = $match[1];
			}
			
			return new XMLNode($tagName, $attr);
		}
	}
	
	function XML($tagName, $attr = array()) {
		return XML::getInstance()->__invoke($tagName, $attr);
	}