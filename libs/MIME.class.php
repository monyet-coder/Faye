<?php
	final class MIME extends Singleton {
		protected static $instance;
		private $mimes = array(
			'doc'	=> 'application/msword',
			'exe'	=> 'application/octet-stream',
			'gzip'	=> 'application/x-gzip',
			'jpg'	=> 'image/jpeg',
			'jpeg'	=> 'image/jpeg',
			'gif'	=> 'image/gif',
			'png'	=> 'image/png',
			
			'js'	=> 'application/javascript',
			'css'	=> 'text/css',
			'json'	=> 'application/json',
			'xml'	=> 'application/xml',
			'html'	=> 'text/html',
			'htm'	=> 'text/html',
			'txt'	=> 'text/plain',
			
			'pdf'	=> 'application/pdf',
			'xls'	=> 'application/vnd.ms-excel',
			'doc'	=> 'application/msword',
			
			'swf'	=> 'application/x-shockwave-flash',
			'zip'	=> 'application/x-compressed',
		);
		
		private $extensions = array();
		
		protected function __construct() {
			$this->extensions = array_keys($this->mimes);
		}
		
		public function getExtensions() {
			return $this->extensions;
		}
		
		public function __get($ext) {
			return isset($this->mimes[$ext]) ? $this->mimes[$ext] : NULL;
		}
	}