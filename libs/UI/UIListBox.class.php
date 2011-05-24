<?php
	App::load()->lib('HTML');

	class UIListBox extends UIComboBox implements iUIMultipleOption {
		protected $selectedIndex = array();
				
		public function __construct($options, $attr = array()) {
			parent::__construct($options, $attr);
			
			$this->setAttr(array(
				'size' => 5,
				'multiple' => 'multiple',
			));
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
	}