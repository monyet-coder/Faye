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
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
	}