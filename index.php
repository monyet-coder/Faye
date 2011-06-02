<?php
	define('__SITE_PATH', __DIR__);
	
	require __SITE_PATH . '/config/constants.php';
	require __SITE_PATH . '/' . __SYSTEM_PATH . '/pattern/Singleton.class.php';
	require __SITE_PATH . '/' . __SYSTEM_PATH . '/Autoload.class.php';
	require __SITE_PATH . '/' . __SYSTEM_PATH . '/App.class.php';	
	
	ini_set('error_prepend_string', '<pre>');
	ini_set('error_append_string', '</pre>');
	
	App::init();