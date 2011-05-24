<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class HTMLController extends Controller {
		public function index() {
			$link = new UILink('http://www.google.com');
			$text = new UIText();
			$link(
				'gOOgle', $text(' this is span')
			);
			
			$list = new UIList(array(
				'First list',
				'second list',
				'third list',
				'4th list',
				'nth list',
				$link,
			));
			
			$HTMLPage = $this->view->load('HTML');
			$HTMLPage->LIST = $list;
			$HTMLPage->TITLE = 'HTML demo page';
			
			foreach($list->getChildren('li a') as $child) {
				$child->append(' Appended');
			}
			
			$user = new User;
			$product = new Product;
				
			$user->findByuserID_AND_username('1', 'will');
			while($user->next()) {
				echo $user->username;
			}
			
			echo $HTMLPage;
		}
	}