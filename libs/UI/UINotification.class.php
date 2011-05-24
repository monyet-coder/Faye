<?php
	class UINotification extends ul {
		public function __construct($lists, $attr = array()) {
			parent::__construct($attr);
			
			$this->addClass('UI UI-Notification');
			
			foreach($lists as $list) {
				HTML('li')->append(
					$list,
					HTML('a', array('href' => '#', 'class' => 'Close'))->append(
						HTML('img', array('src' => 'http://www.winesandvines.com/images/icons/icon_commentsCloseGrey.png'))
					)
				)->appendTo($this);
			}
		}
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			View::getInstance()->addScript('UI/UINotification.js');
			
			return parent::render();
		}
	}