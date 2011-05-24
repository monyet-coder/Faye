<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->database('DatabaseConnection');
	App::load()->database('DatabaseColumn');
	App::load()->database('DatabaseRow');
	App::load()->database('DatabaseResult');
	App::load()->database('QueryCache');
	App::load()->database('aQueryBuilder', '/QueryBuilder');

	class Database extends Singleton {
		const DEFAULT_CONFIG 	= 'default';
		
		protected static $instance;
				
		private $connections 	= array();
		private $currentConfig	= NULL;
		
		protected function __construct() {
			$this->establish(self::DEFAULT_CONFIG);
		}
		
		protected function establish($configName) {
			if($configName === $this->currentConfig) {
				return $this->connections[$this->currentConfig];
			}
			
			$config = array();
			if(is_string($configName)) {
				App::load()->config('database');
				if(!isset(Config::getInstance()->database[$configName])) {
					throw new Exception('The database configuration isn\'t available.');
				}
				
				$config = Config::getInstance()->database[$configName];
			} else if(is_array($configName)) {
				$config = $configName;
				$configName = md5(implode('-', $config));
			} else {
				throw new Exception('Configuration parameter type isn\'t recognized.');
			}
			
			if(!isset($config['host'], $config['user'], $config['pass'], $config['name'])) {
				throw new Exception('Configuration parameter isn\'t complete.');
			}
			
			if(!isset($this->connections[$configName])) {
				$this->connections[$configName] = new DatabaseConnection($config);
			}
			
			$this->currentConfig = $configName;
			
			return $this->connections[$this->currentConfig];
		}
		
		public function getConnection($configName = NULL) {
			if($configName === NULL) {
				$configName = self::DEFAULT_CONFIG;
			}
						
			return $this->establish($configName);
		}
		
		public function getCurrentConfig() {
			return $this->currentConfig;
		}
	}