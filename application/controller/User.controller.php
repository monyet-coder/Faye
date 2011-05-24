<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class UserController extends Controller {
		public function index() {}
		public function search($keyword = NULL) {
			if($this->request->isAJAX()) {
				$user = new User;
				
				$result = 
					$user->
					where('username LIKE', $keyword . '%')->
					getColumn('username');
			
				echo json_encode($result);
			}
		}
	}