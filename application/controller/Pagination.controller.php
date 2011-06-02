<?php	
	App::import('libraries.UI.*');
	
	class PaginationController extends Controller {
		public function index($page = 1) {			
			$totalItem = 127;
			$pagination = new UIPagination($totalItem);
			
			$pagination->URL('Pagination/index');
			$pagination->current($page);
			$pagination->range(10);
			$pagination->showPagination = false;
			
			echo $pagination->build();
		}
	}