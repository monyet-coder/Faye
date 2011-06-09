<?php
	abstract class Multiton {
		protected static $instances;
		
		public static function getInstance($key = NULL) {
			$instance = new static;
			
			if($key === NULL) {
				static::$instances[] = $instance;
			} else {
				static::$instances[$key] = $instance;
			}
			
			
			return $instance;
		}
	}