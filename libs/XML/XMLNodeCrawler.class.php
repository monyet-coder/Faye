<?php
	App::load()->lib('XMLNodeSelector', '/XML');

	class XMLNodeCrawler {
		const DIRECT_CHILDREN 	= '>';
		const UNION			= ',';
		const ALL_CHILDREN		= '';
		
		public $result = array();
		private $nodeSelector = NULL;
		private $parentNode = NULL;
		
		public function __construct($node) {
			$this->parentNode = $node;
		}
		
		public function select($selector, $directOnly = false) {
			$this->nodeSelector = new XMLNodeSelector($selector);
			$result = array();
			
			$tagName = $this->nodeSelector->__get('tagName');
			$id = $this->nodeSelector->__get('id');
			$class = $this->nodeSelector->__get('class');
			$attrName = $this->nodeSelector->__get('attrName');
			$attrOperator = $this->nodeSelector->__get('attrOperator');
			$attrValue = $this->nodeSelector->__get('attrValue');
			$conjunction = $this->nodeSelector->__get('conjunction');
			
			foreach($this->parentNode->getChildren() as $child) {
				$validChild = true;
				
				if($child instanceof XMLNode) {
					if(!empty($tagName) and $tagName !== $child->tagName) {
						$validChild = false;
					} else if(!empty($id) and $id !== $child->attr('id')) {
						$validChild = false;
					} else if(!empty($class) and !in_array($class, explode(' ', $child->attr('class')))) {
						$validChild = false;
					} else if(!empty($attrName) and !empty($attrOperator) and !empty($attrValue)) {
						if(!$child->hasAttr($attrName)) {
							$validChild = false;
						} else {
							switch($attrOperator) {
								case '^=':
									$validChild = strpos($child->attr($attrName), $attrValue) === 0;
								break;
								case '$=':
									$validChild = strrpos($child->attr($attrName), $attrValue) === strlen($child->attr($attrName)) - strlen($attrValue);
								break;
								case '=':
									$validChild = (string)$child->attr($attrName) === (string)$attrValue;
								break;									
								case '!=':
									$validChild = (string)$child->attr($attrName) !== (string)$attrValue;
								break;
								case '~=':
									$validChild = strpos($child->attr($attrName), $attrValue) !== false;
								break;
							}
						}
					}
					
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
			}
			
			return $result;
		}
	}