<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class XMLNode implements ArrayAccess {
		public $tagName			= NULL;
        
		protected $attr 		= array();		
		protected $parent 		= NULL;
		protected $children 	= array();
		protected $isSingleton 	= true;
		
		public function __construct($tagName, $attr = array()) {
			$this->tagName = $tagName;

			$this->attr = self::parseAttributes($attr);
		}
        
		protected static function parseAttributes($attr) {
			if(is_string($attr) and preg_match_all('/(.*?)\=\"(.*?)\"[ ]*/', $attr, $match)) {
				$attr = array_combine($match[1], $match[2]);
			}
			
			return $attr;
		}
		/**
         *
         * @return XMLNode
         */
		public function __invoke() {
			return call_user_func_array(array($this, 'append'), func_get_args());
		}
		
        /**
         *
         * @return XMLNode
         */
		public function getParent() {
			return $this->parent;
		}
		/**
         *
         * @param string $selector
         * @return array
         */
		public function getParents($selector = '*') {
			App::load()->lib('XMLNodeCrawler', '/XML');
			
			$crawler = new XMLNodeCrawler($this);
			$parents = array();
			
			foreach(explode(',', $selector) as $segment) {
				$parents = array_merge($parents, $crawler->selectParent($segment));
			}
			
			return $parents;
		}
		/**
         *
         * @param int $index
         * @return boolean 
         */
		public function hasChildren($index = NULL) {
			if(is_numeric($index)) {
				return !empty($this->children[$index]);
			}
			
			return !empty($this->children);
		}
		/**
         *
         * @param string / int $selector
         * @return array
         */
		public function getChildren($selector = '*', $directOnly = false) {
			if(is_numeric($selector)) {
				return $this->hasChildren($selector) ? $this->children[$selector] : NULL;
			}
			
			if($selector === '*') {
				return $this->children;
			}
			
			// If it is a complex selector,
			// search it with a node crawler.
			App::load()->lib('XMLNodeCrawler', '/XML');
			
			$crawler = new XMLNodeCrawler($this);			
			$result = array();
			
			// If the selector contains comma 
			// delimiter, explode it and search
			// for individual segment, then merge
			// all the result together.
			foreach(explode(',', $selector) as $segment) {
				$result = array_merge($result, $crawler->select($segment, $directOnly));
			}
			
			return $result;
		}
		/**
         *
         * @return XMLNode
         */
		public function getFirstChild() {
			return count($this->children) > 0 ? $this->children[0] : NULL;
		}
		/**
         *
         * @return XMLNode
         */
		public function getLastChild() {
			return count($this->children) > 0 ? $this->children[count($this->children) - 1] : NULL;
		}
		/**
         *
         * @param string / int $selector
         * @return XMLNode 
         */
		public function removeChildren($selector = '*') {
			if($selector === '*') {
				return $this->clearChildren();
			} 
			
			if(is_numeric($selector) and $this->hasChildren($selector)) {
				unset($this->children[$selector]);
			} else if(is_array($selector)) {				
				$this->children = array_diff($this->children, $selector);
			} else if(is_string($selector)) {
				return $this->removeChildren($this->getChildren($selector));
			} else if($selector instanceof XMLNode) {
				$this->children = array_diff($this->children, array($selector));
			}
			
			return $this;
		}
		/**
         *
         * @return XMLNode 
         */
		public function remove() {
			if($this->parent !== NULL) {
				$this->parent->removeChildren($this);
			}
			
			return $this;
		}
		/**
         *
         * @return XMLNode
         */
		public function removeFirstChild() {
			return $this->removeChildren(0);
		}
		/**
         *
         * @return XMLNode
         */
		public function removeLastChild() {
			return $this->removeChildren(count($this->children) - 1);
		}
		
        /**
         *
         * @param int $index
         * @param XMLNode $element
         * @return XMLNode 
         */
		protected function setChild($index, $element) {
			$this->children[$index] = $element;
			
			ksort($this->children, SORT_NUMERIC);
			
			return $this;
		}
		/**
         *
         * @param int $index
         * @param XMLNode $element
         * @return XMLNode 
         */
		public function replaceChildren($index, $element) {
			if(is_numeric($index)) {
				return $this->removeChildren($index)->setChild($index, $element);
			} else if(is_string($index)){
				$children = $this->getChildren($index);
				
				if(!empty($children)) {
					foreach($children as $child) {
						$this->replaceChildren($child, $element);
					}
				} else {
					$childIndex = array_search($index, $this->children);
					
					$this->replaceChildren($childIndex, $element);
				}
			} else if(is_array($index)) {
				foreach($index as $child) {
					$this->replaceChildren($child, $element);
				}
			} else if($index instanceof XMLNode) {
				$childIndex = array_search($index, $this->children);
				
				if($childIndex !== false) {
					$this->replaceChildren($childIndex, $element);
				}
			}
			
			return $this;
		}
		/**
         *
         * @return XMLNode 
         */
		public function clearChildren() {
			$this->children = array();
			
			return $this;
		}
		/**
         *
         * @return XMLNode
         */
        public function clearAttr() {
            $this->attr = array();
            
            return $this;
        }
        /**
         *
         * @param string $attrName
         * @return boolean 
         */
		public function hasAttr($attrName) {
			return isset($this->attr[$attrName]);
		}
		/**
         *
         * @param string $attrName
         * @param string $attrValue
         * @return string
         */
		public function attr($attrName, $attrValue = NULL) {
			if($attrValue !== NULL) {
				return $this->setAttr($attrName, $attrValue);
			}
			
			return $this->hasAttr($attrName) ? $this->attr[$attrName] : NULL;
		}
		/**
         *
         * @param string $attrName
         * @param string $attrValue
         * @return XMLNode 
         */
		public function setAttr($attrName, $attrValue = NULL) {
			if(is_array($attrName)) {
				foreach($attrName as $name => $value) {
					$this->setAttr($name, $value);
				}
				
				return $this;
			}
			
			$this->attr[$attrName] = $attrValue;
			
			return $this;
		}
		/**
         *
         * @param string $attrName
         * @return XMLNode 
         */
		public function removeAttr($attrName) {			
			foreach((array)$attrName as $name) {
				unset($this->attr[$name]);
			}
			
			return $this;
		}
		/**
         *
         * @param XMLNode $parent
         * @return XMLNode 
         */
		protected function setParent(XMLNode $parent) {
			$this->parent = $parent;
			
			return $this;
		}
		/**
         *
         * @param XMLNode / string $child
         * @param string $type
         * @return XMLNode 
         */
		protected function addChild($child, $type) {
			if($type === 'append') {
				$this->children[] = $child;
			} else if($type === 'prepend') {
				array_unshift($this->children, $child);
			}
			
			if($child instanceof XMLNode) {
				$child->setParent($this);
			}
			
			$this->isSingleton = false;
			
			return $this;
		}
		/**
         * @param XMLNode / string
         * @return XMLNode 
         */
		public function prepend() {
			foreach(func_get_args() as $child) {
				$this->addChild($child, __FUNCTION__);
			}
			
			return $this;
		}
		/**
         * @param XMLNode / string
         * @return XMLNode 
         */
		public function append() {			
			foreach(func_get_args() as $child) {
				$this->addChild($child, __FUNCTION__);
			}
			
			return $this;
		}
		/**
         * @param XMLNode $parent
         * @return XMLNode 
         */
		public function appendTo(XMLNode $parent) {
			$parent->append($this);
			
			return $this;
		}
        /**
         *
         * @param XMLNode $parent
         * @return XMLNode 
         */
		public function prependTo(XMLNode $parent) {
			$parent->prepend($this);
			
			return $this;
		}
        /**
         *
         * @return string
         */
        public function getText() {           
            return (string)array_reduce($this->getChildren(), function ($text, $child) {
                if(is_string($child)) {
                    $text .= $child;
                }
                
                return $text;
            });
        }
		/**
         *
         * @param array $attr
         * @return string 
         */
		protected final static function fetchAttr($attr) {
			if(empty($attr)) {
				return NULL;
			}
			
			$attrString = '';
			foreach($attr as $attrName => $attrValue) {
				$quote = (strpos($attrValue, '"') === false ? '"' : "'");
				
				$attrString .= ' ' . $attrName . '=' . $quote . $attrValue . $quote;
			}
			
			return $attrString;
		}

        /**
         *
         * @param string $tagName
         * @param array $attr
         * @param string / array $children
         * @param boolean $isSingleton
         * @return string
         */
		protected final static function markup($tagName, $attr, $children, $isSingleton = true) {
			$attrString = self::fetchAttr($attr);

            return 
                $isSingleton ? 
                '<' . $tagName . $attrString . ' />' : 
                '<' . $tagName . $attrString . '>' . $children . '</' . $tagName . '>';
		}
		
		/**
		* ArrayAccess interface implementation.
		*/
		public function offsetExists($offset) {
			return isset($this->children[$offset]);
		}
		
		public function offsetUnset($offset) {
			return $this->removeChildren($offset);
		}
		
		public function offsetGet($selector) {
			return $this->getChildren($selector);
		}
		
		public function offsetSet($offset, $element) {
			return $this->setChild($offset, $element);
		}
		
		public function __get($attrName) {
			return $this->attr($attrName);
		}
		
		public function __set($attrName, $attrValue) {
			$this->setAttr($attrName, $attrValue);
		}		
		
        /**
         *
         * @return string
         */
		public function render() {
			$children = (string)NULL;
			
			foreach($this->children as $child) {
				//$children .= is_string($child) ? htmlspecialchars($child) : $child;
				$children .= $child;
			}

			return
				self::markup(
					$this->tagName, 
					$this->attr, 
					$children, 
					$this->isSingleton
				);
		}
		
		public function __toString() {
			return $this->render();
		}
	}