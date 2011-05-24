<?php
	App::load()->lib('HTML');

	class UIList extends ul {
		public function __construct($lists = array(), $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-List');
			
			foreach((array)$lists as $list) {
				$li = HTML('li');
				
				$li->append($list);
				$li->appendTo($this);
			}
		}
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			
			return parent::render();
		}
	}