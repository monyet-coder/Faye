<?php
	App::load()->lib('aTraversable', '/Traversal');

	class XMLNodeSelector extends aTraversable {
		const _PATTERN_ = '/([\w-:\*]*)(?:\#([\w-]+)|\.([\w-]+))?(?:\[@?(!?[\w-]+)(?:([!*^$]?=)["\']?(.*?)["\']?)?\])?([\/, >]+)/is';
		
		const _SELECTOR_		= 0;
		const _TAG_ 			= 1;
		const _ID_ 			= 2;
		const _CLASS_ 			= 3;
		const _ATTR_NAME_ 		= 4;
		const _ATTR_OPERATOR_ = 5;
		const _ATTR_VALUE_ 	= 6;
		const _CONJUNCTION_	= 7;

		protected $selector 	= NULL;		
		
		public function __construct($selector) {
			$this->selector = $selector;
			
			$this->parse();
		}
		
		protected function parse() {
			return preg_match_all(self::_PATTERN_, trim($this->selector) . ' ', $this->tData, PREG_SET_ORDER);
		}
		
		public function segment($index) {
			return isset($this->tData[$index]) ? $this->tData[$index] : NULL;
		}
		
		public function remainingSelector() {
			$length = $this->count();
			$remaining = '';
			for($i = $this->tCursor + 1; $i < $length; ++$i) {
				$remaining .= $this->tData[$i][self::_TAG_] . ' ' . $this->tData[$i][self::_CONJUNCTION_] . ' ';
			}
			
			return $remaining;
		}
		
		public function __get($compName) {
			$this->validateCursor();
			
			switch(strtoupper($compName)) {
				case 'TAG':
				case 'TAGNAME':
					$comp = self::_TAG_;
				break;
				case 'ID':
					$comp = self::_ID_;
				break;
				case 'CLASS':
					$comp = self::_CLASS_;
				break;
				case 'ATTRNAME':
					$comp = self::_ATTR_NAME_;
				break;
				case 'ATTRVALUE':
					$comp = self::_ATTR_VALUE_;
				break;
				case 'ATTROPERATOR':
					$comp = self::_ATTR_OPERATOR_;
				break;
				case 'CONJUNCTION':
					$comp = self::_CONJUNCTION_;
				break;
			}
			
			if(isset($comp)) {
				$current = $this->current();
				
				return trim($current[$comp]);
			}
		} 
	}