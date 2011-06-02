<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	App::load()->lib('Benchmark');
	
	class Profiler {
		public function __construct() {
			$this->benchmark = Benchmark::getInstance();
		}
		
		public function __toString() {
			$this->benchmark->mark('APPLICATION_BENCHMARK');
			
			foreach($this->benchmark->getKeys() as $name) {
				$elapsed = $this->benchmark->elapsed($name);
				
				if($elapsed < 0.001) {
					$elapsed *= 1000000;
					$unit = 'microsecs';
				} else if($elapsed < 0.09) {
					$elapsed *= 1000;
					$unit = 'millisecs';
				} else {
					$unit = 'seconds';
				}

				$profiles[] = $name . ' : ' . round($elapsed, 2) . ' ' . $unit . '.';
			}
			
			return 'Request Time : ' . date('d M Y H:i:s', APP_INIT) . '<br />' . implode('<br />', $profiles);
		}
	}