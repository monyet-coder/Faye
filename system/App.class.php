<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class App {
		const PATH = __SITE_PATH;
		
		public static function init() {
			define('APP_INIT', $_SERVER['REQUEST_TIME']);
			require __SITE_PATH . '/' . __SYSTEM_PATH . '/Loader.class.php';

			self::load()->system('Config');
			self::load()->system('Request');
			self::load()->system('Response');
			self::load()->system('Controller');
			self::load()->system('URI');
			self::load()->system('Router');
			self::load()->system('Database');
			self::load()->system('Entity');
			self::load()->system('Model');
			self::load()->system('View');
			
			App::import('application.model.*');
			
			Response::getInstance()->startBuffering();
			Router::getInstance()->run();			
			
			echo Response::getInstance();
		}
		
		public static function basePath($path = '', $suffix = false) {
			return __BASE_PATH . $path . ($suffix ? $suffix : Config::getInstance()->URLSuffix);
		}
		
		public static function load() {
			return Loader::getInstance();
		}
		
		public static function import($package) {
			$package = trim($package);
			
			if(substr($package, -2) === '.*') {
				$package = substr($package, 0, -2);
				$package = str_replace('.', '/', $package);

				Autoload::register($package);
			} else {
				$segments 	= explode('.', $package);
				$category 	= array_shift($segments);
				$class 		= array_pop($segments);
				$subDir 	= '/' . implode($segments);
				
				self::load()->{$category}($class, $subDir);
			}
		}
	}