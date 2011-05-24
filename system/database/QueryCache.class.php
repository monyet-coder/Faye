<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class QueryCache extends Singleton{
		protected static $instance;
		private $cache = array();
		
		public function getCurrentConfig() {
			return Database::getInstance()->getCurrentConfig();
		}
		
		public function exists($query) {
			return isset($this->cache[$this->getCurrentConfig()][$query]);
		}
		
		public function get($query) {
			return $this->cache[$this->getCurrentConfig()][$query];
		}
		
		public function set($query, PDOStatement $statement) {
			$this->cache[$this->getCurrentConfig()][$query] = $statement;
		}
	}