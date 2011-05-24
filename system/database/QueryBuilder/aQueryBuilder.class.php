<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->database('iQueryBuilder', '/QueryBuilder');

	abstract class aQueryBuilder implements iQueryBuilder {
		const HAS_OPERATOR 		= '/(<|>|!|=|IS[\s]+NULL|IS[\s]+NOT[\s]+NULL|[\s]+LIKE[\s]+|NOT[\s]+LIKE|[\s]+IN[\s]+|NOT[\s]+IN)/i';
		const HAS_ARITHMETIC	= '/([+|-|\/|\*|%|^|&|~|\||<<|>>]\s*[0-9]+)/i';
		const HAS_AGGREGATE 	= '/(SUM|COUNT|MIN|MAX|AVG)\s*\((\w+)\)/i';
		const HAS_ALIAS			= '/AS\s+(\w+)/i';
		
		const ORDER_ASC 	= 'ASC';
		const ORDER_DESC 	= 'DESC';		
		const OPEN_QUOTE 	= '';
		const CLOSE_QUOTE 	= '';		
		const TRUE			= '1';
		const FALSE			= '0';		
		const DATETIME_FORMAT	= 'Y-m-d H:i:s';
		
		/**
		* Properties to hold query data.
		*/
		protected $field	= array();
		protected $from		= array();
		protected $where 	= array();
		protected $groupBy	= array();
		protected $orderBy 	= array();
		protected $orderWay = NULL;
		protected $offset	= NULL;
		protected $limit	= NULL;
		
		protected $entity 	= NULL;
		protected $aliasEntity = array();
		
		public function __construct($entity) {
			$this->entity = $entity;
		}
		
		protected function hasAggregate($field) {
			return preg_match(static::HAS_AGGREGATE, $field);
		}
		
		protected function hasOperator($field) {			
			return preg_match(static::HAS_OPERATOR, $field);
		}
		
		protected function hasArithmetic($field) {
			return preg_match(static::HAS_ARITHMETIC, $field);
		}
		
		protected function hasAlias($field) {
			return preg_match(static::HAS_ALIAS, $field);
		}
		
		protected function getAggregate($field) {
			preg_match(static::HAS_AGGREGATE, $field, $match);
			
			return isset($match[1]) ? $match[1] : NULL;
		}
		
		protected function getOperator($field) {
			preg_match(static::HAS_OPERATOR, $field, $match);
			
			return isset($match[1]) ? $match[1] : '=';
		}
		
		protected function getAlias($field) {
			preg_match(static::HAS_ALIAS, $field, $match);
			
			return isset($match[1]) ? $match[1] : NULL;
		}
		
		protected function stripOperator($field) {			
			if($this->hasOperator($field)) {
				return preg_replace(static::HAS_OPERATOR, '', $field);
			}
			
			return $field;
		}
		
		protected function stripArithmetic($field) {			
			if($this->hasArithmetic($field)) {
				return preg_replace(static::HAS_ARITHMETIC, '', $field);
			}
			
			return $field;
		}
		
		protected function stripAggregate($field) {
			if($this->hasAggregate($field)) {
				return preg_replace(static::HAS_AGGREGATE, '\2', $field);
			}
			
			return $field;
		}
		
		protected function stripAlias($field) {
			if($this->hasAlias($field)) {
				return preg_replace(static::HAS_ALIAS, '', $field);
			}
			
			return $field;
		}
		
		protected function getStripped($field) {
			$field = $this->stripOperator($field);
			$field = $this->stripArithmetic($field);
			$field = $this->stripAggregate($field);
			$field = $this->stripAlias($field);
			
			$field = trim($field);
			
			return $field;
		}
		
		public function select() {
			foreach(func_get_args() as $field) {
				if(is_string($field)) {
					if(strpos($field, ',') !== false) {
						foreach(explode(',', $field) as $f) {
							$this->select($f);
						}
					} else {
						$field = trim($field);
						
						$this->field[] = array(
							'fieldName' => static::OPEN_QUOTE . $this->getStripped($field) . static::CLOSE_QUOTE,
							'aggregate'	=> $this->getAggregate($field),
							'alias'		=> 
								$this->hasAlias($field) ? 
									static::OPEN_QUOTE . $this->getAlias($field) . static::CLOSE_QUOTE : 
									static::OPEN_QUOTE . sprintf('%sOf%s', ucfirst(strtolower($this->getAggregate($field))), $this->getStripped($field)) . static::CLOSE_QUOTE,
						);
					}
				} else if(is_array($field)) {
					foreach($field as $f) {
						$this->select($f);
					}
				}
			}
			
			return $this;
		}
		
		protected function aggregate($method, $field) {			
			$this->select(
				sprintf('%s(%s) %s', 
					strtoupper($method), 
					$field, 
					$this->hasAlias($field) ? 'AS ' . $this->getAlias($field) : NULL
				)
			);
			
			return $this;
		}
		
		public function avg() {
			foreach(func_get_args() as $field) {
				$this->aggregate(__FUNCTION__, $field);
			}
			
			return $this;
		}
		
		public function sum() {
			foreach(func_get_args() as $field) {
				$this->aggregate(__FUNCTION__, $field);
			}			
			
			return $this;
		}
		
		public function count() {
			foreach(func_get_args() as $field) {
				$this->aggregate(__FUNCTION__, $field);
			}
						
			return $this;
		}
		
		public function min() {
			foreach(func_get_args() as $field) {
				$this->aggregate(__FUNCTION__, $field);
			}
						
			return $this;
		}
		
		public function max() {
			foreach(func_get_args() as $field) {
				$this->aggregate(__FUNCTION__, $field);
			}
						
			return $this;
		}
		
		public function from() {
			foreach(func_get_args() as $from) {			
				if(is_string($from)) {
					$this->from[] = static::OPEN_QUOTE . $from . static::CLOSE_QUOTE;
				} else if($from instanceof Entity) {
					$this->from[] = sprintf('(%s) Alias%d', $from->getBuilder()->build(), count($this->from));
					$this->aliasEntity[] = $from;
				}
			}
			
			return $this;
		}
		
		public function where($arg1, $arg2 = NULL, $conjunction = 'AND') {	
			if(!empty($arg1) and $arg2 === NULL) {
				if(is_array($arg1)) {
					$ids = array();
					foreach($arg1 as $field => $val) {						
						if(is_numeric($field)) {
							$ids[] = $val;
						} else {
							$this->where($field, $val, $conjunction);
						}
					}
					
					if(!empty($ids)) {
						$this->where($this->entity->getPrimaryKey(), $ids, $conjunction);
					}
				} else if(is_numeric($arg1)) {
					$this->where($this->entity->getPrimaryKey(), $arg1, $conjunction);
				} else if($arg1 instanceof Entity) {
					foreach((array)$this->entity->getForeignKey($arg1) as $FK) {
						$this->where($FK, $arg1, $conjunction);
					}
				}
			} else if(is_string($arg1)) {
				$field = $this->getStripped($arg1);
				
				if(is_numeric($arg2) or is_string($arg2)) {
					$value 			= $arg2;
					$operator 		= $this->getOperator($arg1);
					$placeholder 	= sprintf(':%s_%s', get_class($this->entity), $field);
				} else if(is_array($arg2)) {
					$operator 		= $this->hasOperator($arg1) ? $this->getOperator($arg1) : 'IN';
					$placeholder	= implode(',', array_map(array(Database::getInstance()->getConnection(), 'quote'), $arg2));
				} else if($arg2 instanceof Entity) {
					$operator 		= $this->hasOperator($arg1) ? $this->getOperator($arg1) : 'IN';
					$placeholder	= implode(',', array_map(array(Database::getInstance()->getConnection(), 'quote'), $arg2->getColumn($field, true)));
				}
				
				$this->where[] = compact('field', 'conjunction', 'value', 'operator', 'placeholder');
			}
			
			return $this;
		}

		public function orWhere($arg1, $arg2 = NULL) {
			return $this->where($arg1, $arg2, 'OR');
		}

		public function groupBy() {			
			foreach(func_get_args() as $field) {
				if(is_string($field)) {
					if(strpos($field, ',') !== false) {
						foreach(explode(',', $field) as $f) {
							$this->groupBy($f);
						}
					} else {
						$this->groupBy[] = static::OPEN_QUOTE . trim($field) . static::CLOSE_QUOTE;
					}
				} else if(is_array($field)) {
					foreach($field as $f) {
						$this->groupBy($f);
					}
				}
			}
			
			return $this;
		}
		
		public function orderBy() {
			foreach(func_get_args() as $field) {
				if(is_string($field)) {
					if(strpos($field, ',') !== false) {
						foreach(explode(',', $field) as $f) {
							$this->orderBy($f);
						}
					} else {
						$this->orderBy[] = static::OPEN_QUOTE . trim($field) . static::CLOSE_QUOTE;
					}
				} else if(is_array($field)) {
					foreach($field as $f) {
						$this->orderBy($f);
					}
				}
			}
			
			return $this;
		}
		
		public function asc() {
			$this->orderWay = static::ORDER_ASC;
			
			return $this;
		}
		
		public function desc() {
			$this->orderWay = static::ORDER_DESC;
			
			return $this;
		}
				
		public function offset($offset) {
			$this->offset = (int)$offset;
			
			return $this;
		}
		
		public function limit($limit) {
			$this->limit = (int)$limit;
			
			return $this;
		}
		
		public function reset() {
			$this->field 	= array();
			$this->where 	= array();
			$this->orderBy 	= array();
			$this->orderWay = static::ORDER_ASC;
			$this->offset 	= NULL;
			$this->limit 	= NULL;
			
			$this->aliasEntity = array();
			return $this;
		}
		
		public abstract function build();
		public abstract function buildInsert($data);
		public abstract function buildUpdate($data);
		public abstract function buildDelete();
		protected abstract function buildCondition();
		
		public function __get($key) {
			switch($key) {
				case 'where':
					$this->{$key};
			}
			
			return NULL;
		}

		public function whereValues() {
			$values = array();
			
			foreach($this->where as $where) {
				if(isset($where['value'])) {
					$values[get_class($this->entity) . '_' . $this->getStripped($where['field'])] = $where['value'];
				}
			}
			
			foreach($this->aliasEntity as $alias) {
				$values = array_merge($values, $alias->getBuilder()->whereValues());
			}
			
			return $values;
		}
		
		public function __toString() {
			return (string)$this->build();
		}
	}