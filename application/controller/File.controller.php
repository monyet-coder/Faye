<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class FileController extends Controller {
		public function index() {
			App::load()->lib('TextFile', '/File');
			
			$inet = new TextFile('D:\inet.txt');
			
			$inet->read();
			$inet->prepend('prepend');
			
			echo $inet;
		}
	}