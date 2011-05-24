<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class IndexController extends Controller {
		public function index() {
			
		}
		
		public function ajax() {
			$this->load->lib('jQuery');
			
			jQuery('.UI-Notification li')->fadeOut()->slideUp()->inject();
		}
	}