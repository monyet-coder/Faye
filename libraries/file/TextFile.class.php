<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	App::load()->lib('aFile', '/File');

	class TextFile extends aFile {
		public function readLine() {
			$line = fgets($this->handler);
			
			return $line;
		}
	}