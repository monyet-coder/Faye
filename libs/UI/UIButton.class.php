<?php
	App::load()->lib('HTML');
	
	class UIButton extends button {
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI');
			$this->addClass('UI-Button');
		}
		
		public function setIcon($img) {
			if(is_string($img)) {
				$img = new img(array('src' => $img));
			}
			
			if($this->getChildren(0) instanceof img) {				
				return $this->replaceChildren(0, $img);
			} else {
				return $this->prepend($img);
			}
		}
		
		public function setType($type) {
			if(in_array($type, array(self::BUTTON, self::SUBMIT, self::RESET))) {
				$this->setAttr('type', $type);
			} else {
				trigger_error('Invalid type given for button.');
			}
			
			return $this;
		}
		
		public function setText($text) {
			return $this->append($text);
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
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			
			return parent::render();
		}
	}