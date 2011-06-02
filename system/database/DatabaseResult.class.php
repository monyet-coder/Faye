<?php
	App::load()->lib('aTraversable', '/traversal');

	class DatabaseResult extends aTraversable {		
		public function __construct($rows) {
			foreach((array)$rows as $cells) {
				$this->tData[] = new DatabaseRow($cells);
			}
		}
		
		public function __get($key) {
			if($this->valid()) {
				$row = $this->current();
				
				return $row->__get($key);
			}
		}
	}