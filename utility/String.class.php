<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class String {
		protected static $instance;
		protected static $replace = array(
			'_' => ' ',
			'-' => ' ',
		);
		
		public static function hyphenate($string, $preserveCase = false) {			
			$string = preg_replace('/\s*([a-z]+|[A-Z][a-z]+)/', '-\1', $string);
			$string = trim($string, '-');
			
			if(!$preserveCase) {
				$string = strtolower($string);
			}
			
			return $string;
		}
		
		public static function dash($string, $preserveCase = false) {
			$string = preg_replace('/\s*([a-z]+|[A-Z][a-z]+)/', '_\1', $string);
			$string = trim($string, '_');
			
			if(!$preserveCase) {
				$string = strtolower($string);
			}
			
			return $string;
		}
		
		public static function pascalize($string) {
			$string = str_replace(array_keys(self::$replace), self::$replace, $string);
			$string = ucwords($string);
			$string = str_replace(' ', NULL, $string);
			
			return $string;
		}
		
		public static function camelize($string) {
			$segments = explode(' ', ucwords(str_replace(array_keys(self::$replace), self::$replace, $string)));
			$first = strtolower(array_shift($segments));
			
			return $first . implode($segments);
		}
		
		public static function spaceSeparate($string, $ucwords = true) {
			$string = preg_replace('/([A-Z][A-Z]?[a-z]*)/', ' \1', $string);
			$string = str_replace(array_keys(self::$replace), self::$replace, $string);
			$string = trim($string);
			
			if($ucwords) {
				$string = ucwords($string);
			} else {
				$string = ucfirst(strtolower($string));
			}
			
			
			return $string;
		}
	}