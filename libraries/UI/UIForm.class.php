<?php
	App::import('libraries.HTML');

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
		
		protected function getStyles() {
			$styles = array('UI/UI.css');
			
			return array_merge(parent::getStyles(), $styles);
		}
		
		protected function getScripts() {
			$scripts = array();
			if($this->async) {
				$scripts[] = 'UI/UI.js';
			}
			
			return array_merge(parent::getScripts(), $scripts);
		}
		
		public function render() {
			if($this->async and !empty($this->asyncAction)) {
				$hidden = HTML('input');

				$hidden->addClass('Async-Action');
				$hidden->setAttr('type', 'hidden');
				$hidden->setAttr('value', $this->asyncAction);
				$hidden->appendTo($this);
			}
			
			return parent::render();
		}
	}