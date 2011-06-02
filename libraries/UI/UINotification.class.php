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
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
		
		protected function getScripts() {
			return array_merge(parent::getScripts(), array(
				'UI/UINotification.js',
			));
		}
	}