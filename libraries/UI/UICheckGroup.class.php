<?php
	App::load()->lib('HTML');
	App::load()->lib('iUIMultipleOption', '/UI');

	class UICheckGroup extends ul implements iUIMultipleOption {
		protected $selectedIndex = array();
		
		public function __construct($options, $attr = array()) {
			parent::__construct($attr);
			$this->addClass('UI UI-Check-Group');
			
			foreach($options as $value => $text) {
				$this->append(
					HTML('li')->append(
						HTML('label')->append(
							HTML('input', array('type' => input::CHECK, 'value' => $value)), $text
						)
					)
				);
			}
		}
		
		public function selectedIndex($index) {
			foreach((array)$index as $indexNum) {
				$this->selectedIndex[] = $indexNum;
			}
			
			return $this;
		}
		
		public function unselect($index) {
			$flip = array_flip($this->selectedIndex);
			
			if(isset($flip[$index])) {
				unset($this->selectedIndex[$flip[$index]]);
			}
			
			return $this;
		}
		
		public function val($value = NULL) {
			if($this->hasChildren) {
				if($value === NULL) {
					return $this->children[$this->selectedIndex];
				} else {
					foreach($this->getChildren() as $index => $value) {
						if($child->getChildren(0)->getChildren(0)->attr('name') === $value) {
							$this->selectedIndex($index);
						}
					}
					
					return $value;
				}
			}
		}
		
		public function __set($name, $value) {
			$name = strtolower($name);
			
			switch($name) {
				case 'name':
					foreach($this->getChildren() as $child) {
						$child->getChildren(0)->getChildren(0)->setAttr('name', $value);
					}
				break;
				case 'selectedIndex':
					$this->selectedIndex($value);
				break;
				default:
					parent::__set($name, $value);
			}
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css'
			));
		}
		
		public function render() {
			foreach($this->selectedIndex as $selectedIndex) {
				if($this->hasChildren($selectedIndex)) {
					$this->children[$selectedIndex]->getChildren(0)->getChildren(0)->attr['checked'] = 'checked';
				}
			}
			
			return parent::render();
		}
	}