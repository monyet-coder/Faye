<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	App::load()->lib('HTML');
	
	class Pagination extends ul {		
		/**
		* Integer
		* Total number of pages, counted internally 
		* the formula : $totalPage = ceil($totalItem / $limit);
		*/
		protected $totalPage = 0;
		
		/**
		* Integer
		* Total number of items.
		*/
		protected $totalItem = 0;
		
		/**
		* Integer
		* Number of items shown in one page.
		*/
		protected $limit = 10;
		
		/**
		* Integer
		* Currently active page. Default to 1 or the first page.
		*/
		protected $current = 1;
		/**
		* String
		* The URL
		*/
		protected $URL = '#';
		/**
		* Integer
		* Maximum number of pages shown at a time
		*/
		protected $range = 5;
		
		/**
		* Boolean
		* whether we gonna show the next and previous
		* pagination link.
		*/
		public $showNextPrev	= true;
		
		/**
		* Boolean
		* whether to show the pagination.
		*/
		public $showPagination = true;
		
		/**
		* Boolean
		* whether to show the current page.
		*/
		public $showCurrent = true;
		
		/**
		* Boolean
		* whether to show the first and last
		* pagination link.
		*/
		public $showFirstLast = true;
		
		/**
		* String
		* The string that will be shown on
		* the first pagination link.
		*/
		public $firstText = 'First';
		
		/**
		* String
		* The string that will be shown on
		* the previous pagination link.
		*/
		public $previousText = 'Prev';
		
		/**
		* String
		* The string that will be shown on
		* the next pagination link.
		*/
		public $nextText = 'Next';
		
		/**
		* String
		* The string that will be shown on
		* the last pagination link.
		*/
		protected $lastText	= 'Last';
		
		public function __construct($totalItem) {
			$this->totalItem($totalItem);
			
			parent::__construct();
		}
		
		public function totalItem($totalItem) {
			$this->totalItem = (int)$totalItem;
			$this->totalPage = ceil($this->totalItem / $this->limit);
			
			return $this;
		}
		
		public function current($current) {
			$this->current = (int)$current;
			if($this->current > $this->totalPage) {
				$this->current = $this->totalPage;
			}
			
			return $this;
		}
		
		public function limit($limit) {
			$this->limit = (int)$limit;
			
			return $this;
		}
		
		public function URL($URL) {
			$this->URL = $URL;
			
			return $this;
		}
		
		public function range($range) {
			$this->range = (int)$range;
			
			return $this;
		}
		
		protected function getURL($URL) {
			return App::basePath($URL);
		}
		
		public function build() {			
			$this->clearChildren();
			
			if($this->totalItem <= 1) {
				return $this;
			}
			
			$start 		= ($this->current > ceil($this->range / 2)) ? $this->current - ceil($this->range / 2) : 1;
			$end 		= ($this->totalPage < $this->range) ? $this->totalPage : ($start + $this->range - 1) > $this->totalPage ? $this->totalPage : $start + $this->range - 1;
			$previous 	= ($this->current > 1) ? $this->current - 1 : NULL;
			$next 		= ($this->current < $this->totalPage) ? $this->current + 1 : NULL;
			
			if ($this->current > 1) {
				if($this->showFirstLast) {
					HTML('li')->addClass('First')->append(
						HTML('a', array('href' => $this->getURL($this->URL), 'title' => 'Go to the first page'))->append(
							$this->firstText
						)
					)->appendTo($this);
				}
				
				if($this->showNextPrev) {
					HTML('li')->addClass('Previous')->append(
						HTML('a', array('href' => $this->getURL("{$this->URL}/page/{$previous}"), 'title' => 'Go to the previous page'))->append(
							$this->previousText
						)
					)->appendTo($this);
				}
			}

			if($this->showPagination) {
				for($page = $start; $page <= $end; $page++) {
					if((int)$this->current === (int)$page) {
						HTML('li')->addClass('Current')->append(
							HTML('span')->append(
								$page
							)
						)->appendTo($this);
					} else {				
						HTML('li')->addClass('Pagination')->append(
							HTML('a', array('href' => $this->getURL("{$this->URL}/page/{$page}"), 'title' => "Go to page {$page}"))->append(
								$page
							)
						)->appendTo($this);
					}
				} 
			}
			
			if ($this->current < $this->totalPage) {
				if($this->showNextPrev) {					
					HTML('li')->addClass('Next')->append(
						HTML('a', array('href' => $this->getURL("{$this->URL}/page/{$next}"), 'title' => 'Go to the next page'))->append(
							$this->nextText
						)
					)->appendTo($this);
				}

				if($this->showFirstLast) {
					HTML('li')->addClass('Last')->append(
						HTML('a', array('href' => $this->getURL("{$this->URL}/page/{$this->totalPage}"), 'title' => 'Go to the last page'))->append(
							$this->lastText
						)
					)->appendTo($this);
				}
			}
			
			return $this;
		}
	}