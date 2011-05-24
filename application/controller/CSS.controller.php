<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class CSSController extends Controller {
		public function index() {
			$this->load->lib('CSS', '/HTML');
			
			 
			CSS('.class-name')->
				{'background-color'}(CSS::COLOR_BLACK)->
				{'color'}(CSS::COLOR_WHITE)->
				{'padding'}(CSS::PADDING_SMALL)
			;
			CSS('#css-name')->
				{'color'}(CSS::COLOR_RED)->
				{'margin'}(2, 3, 4, 5)
			;
			CSS('div')->
				{'padding'}(400, 300, 200, 100)->
				{'position'}(CSS::POSITION_ABSOLUTE)->
				{'left'}(200)->
				{'top'}(400)->
				{'background'}(CSS::URL('http://friendster.bigoo.ws/content/layout/fantasy/fantasy_9.jpg'))
			;
			
			CSS::inject();
			echo $this->view->load('css');
		}
	}