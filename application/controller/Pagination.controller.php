<?php
	class PaginationController extends Controller {
		public function index($page = 1) {
			$this->load->lib('Pagination');
			
			$totalItem = 127;
			$pagination = new Pagination($totalItem);
			
			$pagination->URL('Pagination/index');
			$pagination->current($page);
			$pagination->range(10);
			$pagination->showPagination = false;
			
			echo $pagination->build();
		}
	}