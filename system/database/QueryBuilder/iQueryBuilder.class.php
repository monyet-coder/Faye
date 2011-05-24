<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	interface iQueryBuilder {
		public function select();
		public function avg();
		public function sum();
		public function max();
		public function min();
		public function from();
		public function where($arg1, $arg2 = NULL, $conjunction = 'AND');
		public function orWhere($arg1, $arg2 = NULL);
		public function groupBy();
		public function asc();		
		public function desc();		
		public function orderBy();
		public function offset($offset);		
		public function limit($limit);		
		public function reset();
	}