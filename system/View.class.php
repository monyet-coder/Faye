<?php
	App::load()->system('Template');
	App::load()->system('ScriptLoader');
	App::load()->system('StyleLoader');

	class View extends Singleton {
		protected static $instance;
		public $scriptLoader	= NULL;
		public $styleLoader		= NULL;
		
		private $templates = array();
		public $vars = array();
		
		public function __construct() {
			Config::getInstance()->load('defaultScripts');
			Config::getInstance()->load('defaultStyles');
						
			$this->scriptLoader = new ScriptLoader;
			$this->styleLoader 	= new StyleLoader;
			
			$this->vars['SCRIPTS'] = $this->scriptLoader;
			$this->vars['STYLES'] = $this->styleLoader;
			
			foreach(Config::getInstance()->defaultScripts as $scriptName) {
				$this->scriptLoader->add($scriptName);
			}
			
			foreach(Config::getInstance()->defaultStyles as $styleName) {
				$this->styleLoader->add($styleName);
			}
		}
		
		public function addScript($scriptName) {
			$this->scriptLoader->add($scriptName);
			
			return $this;
		}
		
		public function addStyle($styleName) {
			$this->styleLoader->add($styleName);			
			
			return $this;
		}
		
		public function removeScript() {}
		public function removeStyle() {}
		
		public function __set($varName, $varValue) {
			$this->vars[$varName] = $varValue;
		}
		
		public function __get($varName) {
			switch($varName) {
				case 'vars':
					return $this->vars;
				break;
				default:
					return isset($this->vars[$varName]) ? $this->vars[$varName] : NULL;
			}
		}
		
		public function load($file, $vars = array()) {
			$template = $this->templates[] = new Template(__SITE_PATH . '/' . __APPLICATION_PATH . '/' . __VIEW_PATH . '/' . $file . '.html');
			
			foreach($vars as $varName => $varValue) {
				$template->__set($varName, $varValue);
			}
			
			return $template;
		}
	}