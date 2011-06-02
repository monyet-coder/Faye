<?php
	App::load()->lib('XMLNodeSelector', '/XML');

	class XMLNodeCrawler {
		const DIRECT_CHILDREN 	= '>';
		const UNION			= ',';
		const ALL_CHILDREN		= ' ';
		
		public $result = array();
		private $nodeSelector = NULL;
		private $parentNode = NULL;
		
		public function __construct($node) {
			$this->parentNode = $node;
		}
		
		public function match($node, $segments) {			
			extract($segments);

			if(!empty($tagName) and $tagName !== $node->tagName) {
				return false;
			}

			if(!empty($id) and $id !== $node->attr('id')) {
				return false;
			} 
						
			if(!empty($class) and !in_array($class, explode(' ', $node->attr('class')))) {
				return false;
			} 
			
			if(!empty($attrName)) {
				if(!$node->hasAttr($attrName)) {
					return false;
				}
				
				if(!empty($attrOperator) and !empty($attrValue)) {
					switch($attrOperator) {
						case '=':
							return (string)$node->attr($attrName) === (string)$attrValue;						
						case '^=':
							return strpos($node->attr($attrName), $attrValue) === 0;
						case '$=':
							return strrpos($node->attr($attrName), $attrValue) === strlen($node->attr($attrName)) - strlen($attrValue);
						case '!=':
							return (string)$node->attr($attrName) !== (string)$attrValue;
						case '~=':
							return strpos($node->attr($attrName), $attrValue) !== false;
					}
				}
			}
            
			return true;
		}
		
		public function selectParent($selector) {
			$parents = array();
			
			if($selector === '*') {
				$currentNode = $this->parentNode;
				while(($parent = $currentNode->getParent()) !== NULL) {
					$parents[] = $parent;
									
					$currentNode = $parent;
				}
			} else {
				$nodeSelector = new XMLNodeSelector($selector);
				
				$currentNode = $this->parentNode;
				while(($parent = $currentNode->getParent()) !== NULL) {
					if($this->match($parent, $nodeSelector->current())) {
						
						$parents[] = $parent;
					}
					
					$currentNode = $parent;
				}
			}
			
			return $parents;
		}
		
		public function select($selector, $directOnly = false) {
			$this->nodeSelector = new XMLNodeSelector($selector);
			$result = array();
			
			$conjunction = $this->nodeSelector->__get('conjunction');

			foreach($this->parentNode->getChildren() as $child) {				
				if(!($child instanceof XMLNode)) {
					continue;
				}
				
				$validChild = $this->match($child, $this->nodeSelector->current());
				if($validChild === false) {
					if(!$directOnly) {
						$result = array_merge($result, $child->getChildren($selector));
					}
				} else {
					if($this->nodeSelector->hasNext()) {
						switch($conjunction) {
							case self::DIRECT_CHILDREN:
								if($this->nodeSelector->remainingSelector()) {
									$result = array_merge($result, $child->getChildren($this->nodeSelector->remainingSelector(), true));
								}
							break;
							case self::UNION:
								$result[] = $child;
							break;
							case self::ALL_CHILDREN:
								if($this->nodeSelector->remainingSelector()) {
									$result = array_merge($result, $child->getChildren($this->nodeSelector->remainingSelector()));
								}
							break;
						}
					} else {
						$result[] = $child;
					}
				}
				
			}
			
			return $result;
		}
	}