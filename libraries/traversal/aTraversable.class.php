<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->lib('iTraversable', '/traversal');

	abstract class aTraversable implements iTraversable, Countable {
		/**
		* @Integer
		*
		* The property used to determine the current index.
		*/
		public $tCursor = -1;
		
		/**
		* @Array of Mixed
		* 
		* The property used to store the data.
		*/
		protected $tData = array();
		
		/**
		* @Boolean
		* 
		* The property used to determine whether we
		* iterating using foreach or while / do while 
		* loop.
		*/
		protected $useForEach = false;
		
		/**
		* @Void
		* 
		* Constructor, initialize data storing it to 
		* aTraversable::$tData.
		*/
		public function __construct($tData) {
			$this->tData = $tData;
		}
		
		/**
		* @Void
		*		
		* Validated the cursor when it's value
		* is -1 and set it to 0 so right data 
		* can be returned.
		*/ 
		protected function validateCursor() {
			if($this->tCursor < 0) {
				$this->tCursor = 0;
			}
		}
		
		/**
		* @Boolean
		*		
		* Check whether the next index (currentIndex + 1)
		* has any data.
		*/
		public function hasNext() {
			return $this->tCursor < count($this->tData) - 1;
		}
		
		/**
		* @Boolean
		*		
		* Check whether the previous index (currentIndex - 1)
		* has any data.
		*/		
		public function hasPrev() {
			return $this->tCursor > 0;
		}
		
		/**
		* @Mixed
		*		
		* Increment the index to the next index
		* (currentIndex + 1).
		*/
		public function next() {			
			if($this->hasNext()) {
				++$this->tCursor;
				
				return $this->current();
			}
			
			if($this->useForEach) {
				++$this->tCursor;
				
				return $this->current();
			}
		}
		/**
		* @Mixed
		*		
		* Decrement the index to the previous index 
		* (currentIndex + 1).
		*/		
		public function prev() {			
			if($this->hasPrev()) {
				--$this->tCursor;
				
				return $this->current();
			}
		}
		
		/**
		* @Mixed
		*		
		* Alias for aTraversable::prev();
		*/
		public function previous() {
			return $this->prev();
		}
		
		/**
		* @Mixed
		*		
		* Set the index to the last index and 
		* return the last item.
		*/		
		public function last() {
			$this->tCursor = count($this->tData); 
			
			return $this->tData[$this->tCursor - 1];
		}
		/**
		* @Mixed
		*		
		* Set the index to the first index and 
		* return the first item.
		*/
		public function first() {
			$this->tCursor = -1;
			
			return $this->current();
		}
		
		/**
		* @Mixed
		*		
		* Indicate developer is using foreach loop,
		* and return the first item.
		*/
		public function rewind() {
			$this->useForEach = true;
					
			return $this->first();
		}
		
		/**
		* @Mixed
		*
		* Get the current item pointed by the current
		* cursor index. 
		* If the index isn't valid, return NULL instead.
		*/
		public function current() {
			if($this->valid()) {
				return $this->tData[$this->tCursor];
			}
			
			return NULL;
		}
		
		/**
		* @Integer
		*
		* Return the current index or key.
		*/
		public function key() {		
			return $this->tCursor;
		}
		
		/**
		* @Boolean
		*
		* Check whether current index is valid 
		* and has any data.
		*/
		public function valid() {
			$this->validateCursor();
			
			return isset($this->tData[$this->tCursor]);
		}
		
		public function count() {
			return count($this->tData);
		}
		
		public function store($data) {
			$this->tData = $data;
			
			return $this;
		}
	}