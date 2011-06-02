<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	interface iTraversable extends Iterator {
		public function prev();
		public function previous();
		public function first();
		public function last();
		public function hasNext();
		public function hasPrev();
	}