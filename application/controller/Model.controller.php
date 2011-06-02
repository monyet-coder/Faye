<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class ModelController extends Controller {        
		public function index() {
			$categories = new Category;
			
			echo count($categories);
		}
	}