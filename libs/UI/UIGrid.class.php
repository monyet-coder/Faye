<?php
	App::load()->lib('HTML');

	class UIGrid extends table {
		protected $head;
		protected $body;
		protected $foot;
		
		public function __construct($rows) {
			parent::__construct(array());
			
			$this->addClass('UI UI-Grid');
			
			$this->head = HTML('thead')->appendTo($this);
			$this->body = HTML('tbody')->appendTo($this);
			$this->foot = HTML('tfoot')->appendTo($this);
			
			$this->build($rows);
		}
		
		public function build($rows) {
			$firstRow = array_shift($rows);

			$tr = HTML('tr');
			foreach($firstRow as $cell) {
				$th = HTML('th');
				
				$th->append($cell);
				$th->appendTo($tr);
			}
			$this->head->append($tr);
			
			foreach($rows as $row) {
				$tr = HTML('tr');
				foreach($row as $cell) {
					$td = HTML('td');

					$td->append($cell);
					$td->appendTo($tr);
				}
				$this->body->append($tr);
			}
		}
		
		public function hideRow($rowIndex) {			
			if($this->body->hasChildren($rowIndex)) {
				$this->body->getChildren($rowIndex)->hide();
			}
			
			return $this;
		}
		
		public function showRow($rowIndex) {
			if($this->body->hasChildren($rowIndex)) {
				$this->body->getChildren($rowIndex)->show();
			}
			
			return $this;			
		}
		
		public function hideColumn($colIndex) {
			if($this->head->getChildren(0) and $this->body->getChildren(0)->getChildren($colIndex)) {
				$this->head->getChildren(0)->getChildren($colIndex)->addClass('Hide');
			}
			
			if($this->body->getChildren(0) and $this->body->getChildren(0)->getChildren($colIndex)) {
				foreach($this->body->getChildren() as $child) {
					$child->getChildren($colIndex)->addClass('Hide');
				}
			}
			
			return $this;
		}
		
		public function showColumn($colIndex) {
			if($this->head->getChildren(0) and $this->body->getChildren(0)->getChildren($colIndex)) {
				$this->head->getChildren(0)->getChildren($colIndex)->removeClass('Hide');
			}
			
			if($this->body->getChildren(0) and $this->body->getChildren(0)->getChildren($colIndex)) {
				foreach($this->body->getChildren() as $child) {
					$child->getChildren($colIndex)->removeClass('Hide');
				}
			}			
			
			return $this;
		}
		
		public function hideCell($colIndex, $rowIndex) {
			if($this->body->getChildren($rowIndex) and $this->body->getChildren($rowIndex)->getChildren($colIndex)) {
				$this->body->getChildren($rowIndex)->getChildren($colIndex)->addClass('Hide');
			}
			
			return $this;
		}
		
		public function showCell($colIndex, $rowIndex) {
			if($this->body->getChildren($rowIndex) and $this->body->getChildren($rowIndex)->getChildren($colIndex)) {
				$this->body->getChildren($rowIndex)->getChildren($colIndex)->addClass('Hide');
			}
			
			return $this;
		}
	}