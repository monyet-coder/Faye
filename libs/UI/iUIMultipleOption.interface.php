<?php
	App::load()->lib('iUIOption', '/UI');
	
	interface iUIMultipleOption extends iUIOption {
		public function unselect($index);
	}