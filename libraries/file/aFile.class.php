<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	abstract class aFile {
		const DEFAULT_MODE 		= 'r+b';
		
		protected $mode			= self::DEFAULT_MODE;
		protected $handler		= NULL;
		protected $filePath		= '';
		
		// File properties
		protected $size			= 0;
		protected $lastModified = 0;
		protected $lastAccess	= 0;
		protected $dirName		= '';
		protected $extension	= '';
		protected $MIME			= '';
		
		public $content	= '';
		
		public function __construct($filePath = NULL, $mode = self::DEFAULT_MODE) {
			App::load()->lib('Validator');
			if(Validator::getInstance()->URL($filePath)) {
				$filePath = urlencode($filePath);
			}
			
			$this->filePath = $filePath;
			if(!is_file($this->filePath)) {
				touch($this->filePath);
			}
			
			if(strpos($mode, 'b') === false) {
				$mode .= 'b';
			}
			
			$this->mode = $mode;
			$this->handler = fopen($this->filePath, $this->mode);
		}
		
		public function __destruct() {
			fclose($this->handler);
		}
		
		public function read() {
			$this->content = file_get_contents($this->filePath);
			
			return $this;
		}
		
		public function write($content) {
			fwrite($this->handler, $content);
			
			return $this;
		}
		
		public function append($content) {
			fseek($this->handler, $this->size(), SEEK_SET);
			
			return $this->write($content);
		}
		
		public function prepend($content) {
			$this->truncate();
			$this->content = $content . $this->content;
			
			return $this->write($this->content);
		}
		
		public function save() {
			fclose($this->handler);
			fopen($this->filePath);
			
			return $this;
		}
		
		public function truncate() {
			return ftruncate($this->handler, 0);
		}
		
		public function delete() {
			return unlink($this->filePath);
		}
		
		public function lastModified() {
			if(empty($this->lastModified)) {
				$this->lastModified = filemtime($htis->filePath);
			}
			
			return $this->lastModified;
		}
		
		public function lastAccess() {
			if(empty($this->lastAccess)) {
				$this->lastAccess = fileatime($this->filePath);
			}
			
			return $this->lastAccess;
		}
		
		public function size() {
			if(empty($this->size)) {
				$this->size = filesize($this->filePath);
			}
			
			return $this->size;
		}
		
		public function dirName() {
			if(empty($this->dirName)) {
				$this->dirName = realpath($this->filePath);
			}
			
			return $this->dirName;
		}
		
		public function extension() {
			if(empty($this->extension)) {
				$this->extension = pathinfo($this->filePath, PATHINFO_EXTENSION);
			}
			
			return $this->extension;
		}
		
		public function MIME() {
			if(empty($this->MIME)) {
				App::load()->lib('MIME');
				
				$this->MIME = MIME::getInstance()->__get($this->extension());
			}
			
			return $this->MIME;
		}
		
		public function saveTo($newPath) {
			$newFile = new File($newPath);
			$newFile->write($this->content);
			return $newFile->save();
		}
		
		public function copyTo($newPath) {
			return copy($this->filePath, $newPath);
		}
		
		public function cutTo($newPath) {
			return rename($this->filePath, $newPath);
		}
		
		public function __get($name) {
			switch($name) {
				case 'size':
				case 'lastAccess':				
				case 'lastModified':
				case 'dirName':
				case 'extension':
				case 'MIME':
					return $this->{$name}();
			}
		}
		
		public function __toString() {
			if(empty($this->content)) {
				$this->read();
			}
			
			return $this->content;
		}
	}