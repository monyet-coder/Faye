<?php
	App::import('libraries.HTML');

    class UIGridRow extends tr {
        public function __construct($cells = array(), $attr = array()) {
            parent::__construct($attr);
            
            if(is_array($cells)) {
                foreach($cells as $cell) {
                    $this->appendCell($cell);
                }
            }            
        }
        /**
         *
         * @return UIGridRow 
         */
        public function appendCell() {
            foreach(func_get_args() as $element) {
                if($element instanceof UIGridCell) {
                    $cell = $element;
                } else {
                    $cell = new UIGridCell;
                    
                    $cell->append($element);
                }
                
                $cell->appendTo($this);
            }
            
            return $this;
        }
        
        public function prependCell() {
            foreach(func_get_args() as $element) {
                if($element instanceof UIGridCell) {
                    $cell = $element;
                } else {
                    $cell = new UIGridCell;
                    
                    $cell->append($element);
                }
                
                $cell->prependTo($this);
            }
            
            return $this;
        }
    }
    
    class UIGridCell extends td {
        public function __construct($value = NULL, $attr = array()) {
            parent::__construct($attr);
            
            if($value !== NULL) {
                $this->append($value);
            }
        }
    }
    
    class UIGridHeaderCell extends th {
        public function __construct($value, $attr = array()) {
            parent::__construct($attr);
            
            $this->append($value);
        }
    }

	class UIGrid extends table {
		protected $head;
		protected $body;
		protected $foot;
        
        protected $submitter;
		
        /**
         *
         * @var int
         */
        protected $column;
        
		public function __construct($rows = array()) {
			parent::__construct(array());
			
			$this->addClass('UI UI-Grid');
			
			$this->head = HTML('thead')->appendTo($this);
			$this->body = HTML('tbody')->appendTo($this);
			$this->foot = HTML('tfoot')->appendTo($this);
		}
		/**
         *
         * @param array $rows
         * @return UIGrid 
         */
		public function build($rows) {
			$firstRow = array_shift($rows);

			$tr = new UIGridRow;
			foreach($firstRow as $cell) {
				$th = new UIGridHeaderCell;
				
				$th->append($cell);
				$th->appendTo($tr);
			}
			$this->head->append($tr);
			
			foreach($rows as $row) {
				$tr = new UIGridRow;
				foreach($row as $cell) {
					$td = new UIGridCell;

					$td->append($cell);
					$td->appendTo($tr);
				}
				$this->body->append($tr);
			}
            
            return $this;
		}
        /**
         *
         * @return UIGrid 
         */
        public function clearChildren() {
            $this->head->clearChildren();
            $this->body->clearChildren();
            $this->foot->clearChildren();
            
            $this->appendSubmit();
            
            return $this;
        }
        /**
         *
         * @return UIGrid 
         */
        protected function appendSubmit ($submitText = 'Submit') {
            if(empty($this->submitter)) {
                $this->submitter = new UIGridRow;
                $button = new UIButton();
                
                $button->setType(UIButton::SUBMIT);
                $this->submitter->appendCell($button);
            } else {
                $result = $this->submitter->getChildren('button');
                
                $button = $result[0];
            }
            
            $button->setText($submitText);
            
            $this->foot->append($this->submitter);
            
            return $this;
        }
        /**
         *
         * @return int
         */
        public function getColumn() {
            return $this->column;
        }
        
        /**
         *
         * @param int $column
         * @return UIGrid 
         */
        public function setColumn($column) {
            $this->column = $column;
            
            return $this;
        }
		/**
         *
         * @return UIGrid 
         */
        public function appendRow() {
            if(func_num_args() === 1 and is_array($arg = func_get_arg(0))) {
                $cells = $arg;
            } else {
                $cells = func_get_args();
            }
            
            $tr = new UIGridRow($cells);
            
            $tr->appendTo($this->body);
            
            return $this;
        }
        public function prependRow() {
            if(func_num_args() === 1 and is_array($arg = func_get_arg(0))) {
                $cells = $arg;
            } else {
                $cells = func_get_args();
            }
            
            $tr = new UIGridRow($cells);
            
            $tr->prependTo($this->body);
            
            return $this;
        }
        /**
         *
         * @param int $rowIndex
         * @return UIGrid 
         */
		public function hideRow($rowIndex) {			
			if($this->body->hasChildren($rowIndex)) {
				$this->body->getChildren($rowIndex)->hide();
			}
			
			return $this;
		}
		/**
         *
         * @param int $rowIndex
         * @return UIGrid 
         */
		public function showRow($rowIndex) {
			if($this->body->hasChildren($rowIndex)) {
				$this->body->getChildren($rowIndex)->show();
			}
			
			return $this;			
		}
		/**
         *
         * @param int $colIndex
         * @return UIGrid 
         */
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
		/**
         *
         * @param int $colIndex
         * @return UIGrid 
         */
		public function showColumn($colIndex) {
			if($this->head->hasChildren(0) and $this->body->getChildren(0)->hasChildren($colIndex)) {
				$this->head->getChildren(0)->getChildren($colIndex)->removeClass('Hide');
			}
			
			if($this->body->hasChildren(0) and $this->body->getChildren(0)->hasChildren($colIndex)) {
				foreach($this->body->getChildren() as $child) {
					$child->getChildren($colIndex)->removeClass('Hide');
				}
			}
			
			return $this;
		}
		/**
         *
         * @param int $colIndex
         * @param int $rowIndex
         * @return UIGrid 
         */
		public function hideCell($colIndex, $rowIndex) {
			if($this->body->hasChildren($rowIndex) and $this->body->getChildren($rowIndex)->hasChildren($colIndex)) {
				$this->body->getChildren($rowIndex)->getChildren($colIndex)->addClass('Hide');
			}
			
			return $this;
		}
		/**
         *
         * @param int $colIndex
         * @param int $rowIndex
         * @return UIGrid 
         */
		public function showCell($colIndex, $rowIndex) {
			if($this->body->hasChildren($rowIndex) and $this->body->getChildren($rowIndex)->hasChildren($colIndex)) {
				$this->body->getChildren($rowIndex)->getChildren($colIndex)->removeClass('Hide');
			}
			
			return $this;
		}
        /**
         *
         * @return UIGridRow
         */
        public function getFirstRow() {
            return $this->body->getFirstChild();
        }
        /**
         *
         * @return UIGridRow
         */
        public function getLastRow() {
            return $this->body->getLastChild();
        }
		/**
         *
         * @return array 
         */
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
	}