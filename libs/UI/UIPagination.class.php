<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->lib('Pagination');

	class UIPagination extends Pagination {
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI')->addClass('UI-Pagination');
		}
	}