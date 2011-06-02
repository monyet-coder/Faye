<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
    
    interface inline {}
    interface block {}
    interface listItem {}
    
	class a extends HTMLElement implements inline {
		protected $isSingleton = false;
				
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('href' => ''));
		}
	}
	
	class link extends HTMLElement {		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('href' => NULL, 'rel' => 'stylesheet', 'type' => 'text/css'));
		}
	}
	
	class script extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('src' => NULL, 'type' => 'text/javascript'));
		}
	}
	
	class style extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('type' => 'text/css', 'media' => 'screen'));
		}
	}
	
	class head extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class body extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class button extends HTMLElement {
		const SUBMIT 	= 'submit';
		const BUTTON 	= 'button';
		const RESET 	= 'reset';
				
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class br extends HTMLElement {
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class img extends HTMLElement implements inline {	
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('src' => ''));
		}
	}
	
	class p extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class pre extends HTMLElement implements block {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class strong extends HTMLElement implements inline {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class em extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class div extends HTMLElement implements block {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
    class dl extends HTMLElement implements listItem {
        protected $isSingleton = false;
        
        public function __construct($attr = array()) {
            parent::__construct(__CLASS__, $attr);
        }
    }
    
	class span extends HTMLElement implements inline {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h1 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h2 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h3 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h4 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h5 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class h6 extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class table extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class tr extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class th extends HTMLELement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class td extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class thead extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class tbody extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class tfoot extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class ul extends HTMLElement implements listItem {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class li extends HTMLElement implements listItem {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class fieldset extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class legend extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class form extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('method' => 'post', 'enctype' => 'multipart/form-data'));
		}
	}
	
	class label extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
	}
	
	class input extends HTMLElement {
		const TEXT 		= 'text';
		const FILE 		= 'file';
		const HIDDEN 	= 'hidden';
		const CHECK 	= 'checkbox';
		const RADIO 	= 'radio';
		const PASSWORD 	= 'password';
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
			
			$this->setAttr($this->attr + array('type' => self::TEXT));
		}
        
        public function val($value = NULL) {
			if($value === NULL) {
				return $this->hasAttr('value') ? $this->attr('value') : NULL;
			} else {
				$this->setAttr('value', $value);
				
				return $value;
			}			
		}
	}
	
	class select extends HTMLElement {
		protected $isSingleton = false;
		protected $selectedIndex = 0;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
		
		public function selectedIndex($index) {
			$this->selectedIndex = $index;
            
            return $this;
		}
		
		public function val($value = NULL) {
			if($this->hasChildren()) {
				if($value === NULL) {
					return $this->getChildren($this->selectedIndex).val();
				} else {
					foreach($this->getChildren() as $index => $child) {
						if($child->value === $value) {
							$this->selectedIndex($index);
						}
					}
				}
			}
		}
		
		public function __set($attrName, $attrValue) {			
			switch($attrName) {
				case 'selectedIndex':
					$this->selectedIndex($attrValue);
				break;
				default:
					parent::__set($attrName, $attrValue);
			}
		}
		
		public function __get($attrName) {
			switch($attrName) {
				case 'selectedIndex':
					return $this->selectedIndex;
				break;
				default:
					return parent::__get($attrName);
			}
		}
		
		public function render() {
			foreach((array)$this->selectedIndex as $selectedIndex) {
                foreach($this->getChildren('option[value="' . $selectedIndex . '"]') as $option) {
                    $option->setAttr('selected', 'selected');
                }
			}
			
			return parent::render();
		}
	}
	
	class option extends HTMLElement {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr + array('value' => NULL));
		}
	}
	
	class textarea extends HTMLElement implements inline {
		protected $isSingleton = false;
		
		public function __construct($attr = array()) {
			parent::__construct(__CLASS__, $attr);
		}
        
        public function val($value) {
            return $this->append($value);
        }
	}
	
	