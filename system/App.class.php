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
			self::load()->lib('Benchmark');
			
			Benchmark::getInstance();
			Response::getInstance()->startBuffering();
			Router::getInstance()->run();
			
			echo Response::getInstance();
			
			echo Benchmark::getInstance();
		}
		
		public static function basePath($path = '') {
			return __BASE_PATH . $path . Config::getInstance()->urlSuffix;;
		}
		
		public static function load() {
			return Loader::getInstance();
		}
	}