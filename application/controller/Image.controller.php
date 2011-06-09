<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class ImageController extends Controller {
		public function index() {
			$this->load->lib('Image');
			
			$image = new Image('http://4.bp.blogspot.com/_2AQpQhLAkCU/SQICc7H4t7I/AAAAAAAAABU/SDTs9eHTDpY/S660/venom.png');
			
			$image->
				resizeTo(400, 480)->
				rotate(180)->
				saveTo(App::PATH . '/resource/images/venom.png', true);
			
			echo $image->toTag();
		}
	}