<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Template {
		const OPEN_TAG = '{';
		const CLOSE_TAG = '}';
		
		private $file		= NULL;
		private $vars 		= array();
		private $parsed		= false;
		private $content	= NULL;
		
		public function __construct($file) {
			$this->file = $file;
			
			$this->getContent();
		}
		
		protected function getContent() {
			ob_start();
			include $this->file;
			$this->content = ob_get_contents();
			ob_end_clean();
		}
		
		public function __set($varName, $varValue) {
			if(strtolower($varName) === 'vars') {
				$this->vars = $varValue;
			}
			
			$this->vars[$varName] = $varValue;
		}
		
		public function __get($varName) {
			if(strtolower($varName) === 'vars') {
				return $this->vars;
			}
			
			return $this->vars[$varName];
		}
		
		protected function parse() {
			if($this->parsed) {
				return;
			}
			
			if(preg_match_all('/' . self::OPEN_TAG . '(\w*)' . self::CLOSE_TAG . '/', $this->content, $matches)) {
				$replace = array();
				
				foreach($matches[1] as $varName) {
					$replace[self::OPEN_TAG . $varName . self::CLOSE_TAG] = isset($this->vars[$varName]) ? (string)$this->vars[$varName] : NULL;
				}
				
				foreach(View::getInstance()->vars as $varName => $var) {
					$replace[self::OPEN_TAG . $varName . self::CLOSE_TAG] = $var;
				}
			}
			
			$this->content = str_replace(array_keys($replace), $replace, $this->content);			
			$this->parsed = true;
		}
		
		public function __toString() {
			$this->parse();
			
			return (string)$this->content;			
		}
	}