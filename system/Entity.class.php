<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	abstract class Entity implements ArrayAccess, iTraversable, iQueryBuilder, Countable {
		protected $db			= NULL;
		protected $data			= array();
		protected $result		= NULL;
		protected $config		= array();
		/**
		* Instance of xxxQueryBuilder class
		* used for building query specifically
		* for this entity.
		*/
		protected $builder		= NULL;
		
		/**
		* An array of objects containing relations
		* to this entity. Used for lazy loading.
		*/
		protected $relations	= array();
		protected $entityName	= NULL;
		protected $queryCache 	= NULL;
		protected $affectedRows	= 0;
		protected $configName	= Database::DEFAULT_CONFIG;
		protected $primaryKey	= NULL;
		protected $column 	= NULL;
		// Event handlers
		protected static $eventList = array(
			'onBeforeInsert', 'onAfterInsert',
			'onBeforeUpdate', 'onAfterUpdate',
			'onBeforeDelete', 'onAfterDelete',
		);
		protected $onBeforeInsert 	= array();
		protected $onAfterInsert	= array();
		protected $onBeforeUpdate	= array();
		protected $onAfterUpdate	= array();
		protected $onBeforeDelete	= array();
		protected $onAfterDelete	= array();

		public $insertID 		= 0;
	
		public function __construct($configName = Database::DEFAULT_CONFIG) {
			$this->queryCache 	= QueryCache::getInstance();
			$this->configName 	= $configName;			
			
			$this->connect($this->configName);
			
			$this->init();
		}
		
		protected function init() {
			$this->column = new DatabaseColumn;
			
			$builderName = ucfirst(strtolower($this->config['driver'])) . 'QueryBuilder';
			App::load()->database($builderName, '/QueryBuilder');
			
			$this->builder = new $builderName($this);
			$this->builder->from($this->entityName);
			
			$this->analyze();
		}		
		
		protected function analyze() {
			try{
				// General analyzer for supported driver
				$statement = $this->execute($this->builder->limit(1)->build());
				for($i = 0; $i < $statement->columnCount(); ++$i) {
					$column = $statement->getColumnMeta($i);
					
					$this->column->add($column['name'], $column['native_type'], $column['len']);
					
					if(empty($this->primaryKey) and in_array('primary_key', $column['flags'])) {
						$this->primaryKey = $column['name'];
					}
				}
			} catch(Exception $e) {
				// Special analyzer for unsupported driver	
				$analyzerName = ucfirst(strtolower($this->config['driver'])) . 'Analyzer';
				App::load()->database($analyzerName, '/Analyzer');
				
				$analyzer = new $analyzerName($this);
				
				$this->column = $analyzer->getColumn();
				if(empty($this->primaryKey)) {
					$this->primaryKey = $analyzer->getPrimaryKey();
				}
			}
			
			$this->builder->reset();
		}
		
		protected function connect($configName = Database::DEFAULT_CONFIG) {
			if($this->configName === $configName and !empty($this->db)) {
				return;
			}
			
			$this->db = Database::getInstance()->getConnection($configName);
			$this->configName = $configName;
			$this->config = Config::getInstance()->database[$this->configName];
		}
		
		public function useConfig($configName) {
			$this->connect($configName);
			$this->init();
			
			return $this;
		}
		
		public function getAffectedRows() {
			return $this->affectedRows;
		}
		
		public function getEntityName() {
			return $this->entityName;
		}
		
		public function getPrimaryKey() {
			return $this->primaryKey;
		}
		
		public function getBuilder() {
			return $this->builder;
		}
		/**
         *
         * @param int, string $num
         * @return DatabaseColumn
         */
		public function getColumn($num = NULL) {
			if($num === NULL) {
				return $this->column;
			}
			
			if(is_numeric($num)) {
				return $this->column->__get(0);
			}
		}
		
		public function getConfig($configKey = NULL) {
			if($configKey === NULL) {
				return $this->config;
			}
			
			return $this->config[$configKey];
		}
		
		public function getConfigName() {
			return $this->configName;
		}
		
		public function find($field, $value = NULL) {
			return $this->where($field, $value)->exec();
		}
		
		public function findFirst($field, $value = NULL) {
			return $this->where($field, $value)->limit(1)->exec();
		}
		
		public function findLast($field, $value = NULL) {
			return $this->where($field, $value)->limit(1)->desc()->exec();
		}
		
		protected function findBy($fieldString, $args) {
			$fieldString = str_ireplace(array('_and_', '_or_'), array(' AND ', ' OR '), $fieldString);
			
			$fieldCount = 0;
			$currentConjunction = 'AND';
			foreach(explode(' ', $fieldString) as $index => $segment) {
				$segment = trim($segment);
				
				if($segment === 'AND' or $segment === 'OR') {
					$currentConjunction = $segment;
				} else {
					$this->where($segment, $args[$fieldCount], $currentConjunction);
					
					++$fieldCount;
				}
			}
			
			return $this->exec();
		}
		
		public function __call($method, $args) {
			if(substr_compare($method, 'findBy', 0, 6) === 0) {
				return $this->findBy(substr($method, 6), $args);
			}
			
			return $this;
		}	

		/**
		* iTraversable interface implementation
		* just delegating the function call to the 
		* Entity::$result.
		*/
		public function prev() {
			if(empty($this->result)) {
				$this->exec();
			}
			
			if($this->result->prev()) {
				return $this;
			}
		}
		
		public function next() {
			if(empty($this->result)) {
				$this->exec();
			}
			
			return $this->result->next();
		}
		
		public function first() {
			if(empty($this->result)) {
				$this->exec();
			}
			
			if($this->result->first()) {
				return $this;
			}
		}
		
		public function last() {
			if(empty($this->result)) {
				$this->exec();
			}
			
			if($this->result->last()) {
				return $this;
			}
		}
		
		public function previous() {						
			return $this->prev();
		}
		
		public function valid() {
			return $this->result->valid();
		}
		
		public function hasNext() {
			return $this->result->hasNext();
		}
		
		public function hasPrev() {
			return $this->result->hasPrev();
		}
		
		public function current() {
			if($this->result->valid()) {
				return $this;
			}
		}
		
		public function key() {
			return $this->result->key();
		}
		
		public function rewind() {
			if(empty($this->result)) {
				$this->exec();
			}
			
			return $this->result->rewind();
		}
		
		/**
		* iQueryBuilder interface implementations
		* just delegating the function call to the 
		* Entity::$builder.
		*/
		public function select() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function avg() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function sum() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function count() {
			$args = func_get_args();
			
			if(empty($args)) {
				if(empty($this->result)) {
					$this->exec();
				}
				
				return $this->result->count();
			}
			
			call_user_func_array(array($this->builder, __FUNCTION__), $args);
			
			return $this;
		}
		
		public function max() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function min() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}								
		
		public function from() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function where($arg1, $arg2 = NULL, $conjunction = 'AND') {
			$this->builder->where($arg1, $arg2, $conjunction);
			
			return $this;
		}
		
		public function orWhere($arg1, $arg2 = NULL) {
			$this->builder->where($arg1, $arg2, 'OR');
			
			return $this;
		}
		
		public function groupBy() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function orderBy() {
			call_user_func_array(array($this->builder, __FUNCTION__), func_get_args());
			
			return $this;
		}
		
		public function asc() {
			$this->builder->asc();
			
			return $this;
		}
		
		public function desc() {
			$this->builder->desc();
			
			return $this;
		}
		
		public function limit($limit) {
			$this->builder->limit($limit);
			
			return $this;
		}
		
		public function offset($offset) {
			$this->builder->offset($offset);
			
			return $this;
		}
		
		public function reset() {
			$this->builder->reset();
			
			return $this;
		}
		
		public function exec() {
			$statement = $this->execute($this->builder->build(), $this->builder->whereValues());
			
			Benchmark::getInstance()->mark('DB_RESULT_ASSIGNMENT');
			$this->result = new DatabaseResult($statement->fetchAll(PDO::FETCH_ASSOC));
			Benchmark::getInstance()->mark('DB_RESULT_ASSIGNMENT');
			
			$this->builder->reset();

			return $this;
		}
		
		protected function trigger() {
			$args = func_get_args();
			$eventName = array_shift($args);
			
			foreach($this->{$eventName} as $eventHandler) {
				call_user_func_array($eventHandler, array_merge(array($this), $args));
			}
			
			return $this;
		}
		
		public function on($eventName, $handler) {
			$eventName = 'on' . $eventName;
			if(!in_array($eventName, self::$eventList)) {
				$this->{$eventName}[] = $handler;
			}			
			
			return $this;
		}
		
		public function onBeforeInsert($handler) {
			return $this->on('BeforeInsert', $handler);
		}
		
		public function onAfterInsert($handler) {
			return $this->on('AfterInsert', $handler);
		}
		
		public function onBeforeUpdate($handler) {
			return $this->on('BeforeUpdate', $handler);			
		}
		
		public function onAfterUpdate($handler) {
			return $this->on('AfterUpdate', $handler);
		}
		
		public function onBeforeDelete($handler) {
			return $this->on('BeforeDelete', $handler);
		}
		
		public function onAfterDelete($handler) {
			return $this->on('AfterDelete', $handler);
		}
		
		protected function execute($query, $params = array()) {
			if($this->queryCache->exists($query)) {
				$statement = $this->queryCache->get($query);
			} else {		
				$statement = $this->db->prepare($query);
				
				$this->queryCache->set($query, $statement);
			}
			
			if(!$statement->execute($params)) {
				$error = $statement->errorInfo();
				
				throw new Exception($error[2]);
			}
			$this->affectedRows = $statement->rowCount();
			
			return $statement;
		}
		
		public function insert() {			
			$this->trigger('onBeforeInsert');

			$this->execute($this->builder->buildInsert($this->data), $this->data);
			$this->insertID = $this->db->lastInsertId();
			$this->builder->reset();
			
			$this->trigger('onAfterInsert', $this->insertID);
			
			return $this;
		}
		
		public function update() {
			$this->trigger('onBeforeUpdate');
			
			if(func_num_args()){
				call_user_func_array(array($this, 'where'), func_get_args());
			}
							
			$setValues = array();
			foreach($this->data as $field => $value) {
				$setValues['v_' . $field] = $value;
			}
			
			$this->execute($this->builder->buildUpdate($this->data), $setValues + $this->builder->whereValues());
			$this->builder->reset();

			$this->trigger('onAfterUpdate');

			return $this;
		}
		
		public function delete() {
			$this->trigger('onBeforeDelete');
			
			if(func_num_args()){
				call_user_func_array(array($this, 'where'), func_get_args());
			}
			
			$this->execute($this->builder->buildDelete(), $this->builder->whereValues());
			$this->builder->reset();
			
			$this->trigger('onAfterDelete');
			
			return $this;
		}
		
		public function getField($column, $unique = false) {
			$columns = array();
			
			if($column === '{PRIMARY_KEY}') {
				$column = $this->primaryKey;
			}
			
			if(is_numeric($column)) {
				$column = $this->columnModel->names($column);
			}
			
			if($unique) {
				$cache = array();
				foreach($this as $row) {
					$value = $this->__get($column);
					
					if(!isset($cache[$value])) {
						$columns[] = $value;
						
						$cache[$value] = true;
					}
				}
			} else {
				foreach($this as $row) {
					$columns[] = $this->__get($column);
				}
			}
			
			return $columns;
		}
		
		public function getForeignKey($relation) {
			$keys = array_intersect($this->columnModel->names, $relation->columnModel->names);
			
			return reset($keys);
		}
				
		// Array Access implementation
		public function offsetExists($name) {
			try { 
				$this->__get($name);
				
				return true;
			} catch(Exception $e) {
				return false;
			}
		}
		
		public function offsetUnset($name) {}
		
		public function offsetGet($name) {
			return $this->__get($name);
		}
		
		public function offsetSet($name, $value) {
			$this->__set($name, $value);
		}		
		
		public function __get($name) {
			if(empty($this->result)) {
				$this->exec();
			}
		
			$result = $this->result->__get($name);
			
			if($result !== NULL) {
				return $result;
			}
			
			if(!Model::exists($name)) {
				throw new Exception('No field or entity found for specified name.' . $name);
			}
			
			if(isset($this->relations[$name])) {
				$relation = $this->relations[$name];
			} else {
				$relation = new $name;
				
				$this->relations[$name] = $relation;
			}
			
			$foreignKey = $this->getForeignKey($relation);
			
			if(empty($foreignKey)) {
				throw new Exception('No relational field found between entities.');
			}
			
			if($this->__get($foreignKey) !== $relation->__get($foreignKey)) {
				$relation->
					where($foreignKey, $this->__get($foreignKey))->
					exec();
			}			
			
			return $relation;
		}
		
		public function __set($key, $value) {
			if(in_array($key, $this->columnModel->names)) {
				return $this->data[$key] = $value;
			}
			
			throw new Exception('Invalid field name specified.');
		}
	}