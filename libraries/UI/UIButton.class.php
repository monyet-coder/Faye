<?php
	App::load()->lib('HTML');
	
	class UIButton extends button {
        protected $icon;
        
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI');
			$this->addClass('UI-Button');
		}
		
		public function setIcon($img) {
			if(is_string($img)) {
				$this->icon = new img(array('src' => $img));
			}
			
			if($this->getChildren(0) instanceof img) {				
				return $this->replaceChildren(0, $this->icon);
			} else {
				return $this->prepend($this->icon);
			}
		}
		
        public function getIcon() {
            return $this->icon;
        }
        
		public function setType($type) {
			if(in_array($type, array(self::BUTTON, self::SUBMIT, self::RESET))) {
				$this->setAttr('type', $type);
			} else {
				throw new Exception('Invalid type given for button.');
			}
			
			return $this;
		}
		
        public function getType() {
            return $this->attr('type');
        }
        
		public function setText($text) {
			return $this->removeLastChild()->append($text);
		}
        
		public function __set($name, $value) {
			$name = strtolower($name);
			
			switch($name) {
				case 'icon':
					$this->setIcon($value);
				break;
				case 'type':
					$this->setType($value);
				break;
				case 'text':
					$this->setText($value);
				break;
				default:
					parent::__set($name, $value);
			}
		}
		
		public function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
	}