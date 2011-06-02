<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->lib('HTML');
	App::load()->lib('iUIOption', '/UI');

	class UIRadioGroup extends ul implements iUIOption {
		protected $selectedIndex = 0;
		
		public function __construct($options, $attr = array()) {
			parent::__construct($attr);
			$this->addClass('UI UI-Radio-Group');
						
			foreach($options as $value => $text) {				
				$this->append(
					HTML('li')->append(
						HTML('label')->append(
							HTML('input', array('type' => input::RADIO, 'value' => $value)), $text
						)
					)
				);
			}
		}

		public function selectedIndex($index) {
			if(isset($this->children[$index])) {
				$this->selectedIndex = $index;
			};
		}
		
		public function val($value = NULL) {
			if($this->hasChildren) {
				if($value === NULL) {
					return $this->getChildren($this->selectedIndex)->getChildren(0)->getChildren(0)->attr('value');
				} else {
					foreach($this->getChildren() as $index => $child) {
						if($child->getChildren(0)->getChildren(0)->attr('value') === $value) {
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
				'UI/UI.css',
			));
		}
		
		public function render() {
			if($this->hasChildren($this->selectedIndex)) {
				$this->children[$this->selectedIndex]->getChildren(0)->getChildren(0)->attr['checked'] = 'checked';
			}
			
			return parent::render();
		}
	}