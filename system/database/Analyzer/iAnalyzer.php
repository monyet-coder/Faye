<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	interface iAnalyzer {
		public function __construct(Entity $entity);
		
		public function getColumn();
		public function getPrimaryKey();
	}