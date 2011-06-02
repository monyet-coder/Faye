<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	App::load()->lib('HTML');
	
	class UITypeahead extends UIForm {
		const LOCAL_SOURCE = 'Local-Source';
		const REMOTE_SOURCE = 'Remote-Source';
		
		protected $textbox 	= NULL;
		protected $holder		= NULL;
		protected $sourceType	= NULL;
		protected $dataSource = NULL;
		
		public function __construct($attr = array()) {
			parent::__construct('', $attr);
			
			$this->addClass('UI-Typeahead');
			
			$this->textbox = new UITextField();
			$this->textbox->appendTo($this);
			
			$this->holder = new UIList;
			$this->holder->addClass('UI-Typeahead-Placeholder');
			$this->holder->appendTo($this);
		}
		
		public function setSource($source) {
			if(is_array($source)) {
				$this->dataSource = json_encode($source);
				$this->sourceType = self::LOCAL_SOURCE;
			} else if(is_string($source)) {
				$this->dataSource = $source;
				$this->sourceType = self::REMOTE_SOURCE;
			} else if($source instanceof Entity) {
				$ids = $source->getColumn(0);
				$texts = $source->getColumn(1);
				
				$this->dataSource = json_encode($texts);
				$this->sourceType = self::LOCAL_SOURCE;
			}
			
			return $this;
		}
		
		public function getSource() {
			return json_decode($this->dataSource);
		}
		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
		
		protected function getScripts() {
			return array_merge(parent::getScripts(), array(
				'UI/UITypeahead.js',
			));
		}
		
		public function render() {
			$hidden = HTML('input');
			
			$hidden->addClass('Source-Holder');
			$hidden->setAttr('type', input::HIDDEN);
			$hidden->setAttr('value', $this->dataSource);
			$hidden->appendTo($this);
			
			$this->addClass($this->sourceType);
			
			return parent::render();
		}
	}