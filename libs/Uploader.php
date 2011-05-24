<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Uploader {
		protected $key;
		protected $file;
		
		public function __construct($key) {
			$this->key = $key;
			$this->file = $_FILES[$key];
		}
	}