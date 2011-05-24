<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	abstract class AbstractQueryBuilder {
		const ORDER_ASC = 'ASC';
		const ORDER_DESC = 'DESC';
		
		protected $field	= array();
		protected $from		= NULL;
		protected $where 	= array();
		protected $orderBy 	= array();
		protected $orderWay = NULL;
		protected $offset	= NULL;
		protected $limit	= NULL;
		
		protected static $readOnly = array(
			'where',
		);
		
		protected function hasOperator($field) {
			$regex = '/(\s|<|>|!|=|is null|is not null|like)/i';
			
			if(preg_match($regex, $field)) {
				return true;
			}

			return false;
		}
		
		protected function stripOperator($field) {
			$regex = '/(\s|<|>|!|=|is null|is not null|like)/i';
			
			if(preg_match($regex, $field)) {
				return preg_replace($regex, '', $field);
			}
			
			return $field;
		}
		
		public function select() {
			$fields = func_get_args();

			if(empty($fields)) {
				return $this;
			}

			foreach($fields as $field) {
				$this->field = $this->field + explode(',', $field);
			}
			
			return $this;
		}
		
		public function from($from) {
			$this->from = $from;
			
			return $this;
		}
		
		public function where() {
			$args = func_get_args();
			
			if(empty($args)) {
				return $this;
			}
			
			if(is_array($args[0])) {
				$this->where += $args[0];
			} else if(count($args) == 2) {				
				$this->where += array(trim($args[0]) => $args[1]);
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
		
		public function order() {
			$fields = func_get_args();

			if(empty($fields)) {
				return $this;
			}

			foreach($fields as $field) {
				$this->orderBy = $this->orderBy + explode(',', $field);
			}
			
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
		
		public function clear() {
			$this->field 	= array();
			$this->where 	= array();
			$this->orderBy 	= array();
			$this->orderWay = static::ORDER_ASC;
			$this->offset 	= NULL;
			$this->limit 	= NULL;
		}
		
		public abstract function build();
		
		public function __get($key) {
			if(in_array($key, static::$readOnly)) {
				return $this->$key;
			}
			
			return NULL;
		}
		
		public function __toString() {
			return (string)$this->build();
		}
	}