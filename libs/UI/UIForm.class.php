<?php
	App::load()->lib('HTML');
	
	class UIForm extends form {
		protected $async;
		protected $asyncAction;
		
		public function __construct($action = '', $attr = array()) {
			parent::__construct($attr);
			
			$this->setAttr('action', $action);
			$this->addClass('UI UI-Form');
		}
		
		public function async($asyncAction = NULL) {
			$this->async = true;
			
			if($asyncAction !== NULL) {
				$this->asyncAction = $asyncAction;				
			}
			
			$this->addClass('Async');
			
			return $this;			
		}
		
		public function render() {
			View::getInstance()->addStyle('UI/UI.css');
			if($this->async) {
				if(!empty($this->asyncAction)) {
					$hidden = HTML('input');

					$hidden->addClass('Async-Action');
					$hidden->setAttr('type', 'hidden');
					$hidden->setAttr('value', $this->asyncAction);
					$hidden->appendTo($this);
				}
				
				View::getInstance()->addScript('UI/UI.js');
			}
			
			return parent::render();
		}
	}