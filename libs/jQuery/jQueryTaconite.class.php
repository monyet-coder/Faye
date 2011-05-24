<?php
	App::load()->lib('XML');

	class jQueryTaconite {
		private $jQuery;
		
		public function __construct($jQuery) {
			$this->jQuery = $jQuery;
		}
		
		public function render() {
			Response::getInstance()->setContentType('xml');
			
			$taconite = XML('taconite');
			foreach($this->jQuery->actions as $action) {
				$selector = $action['selector'];					
				
				foreach($action['chain'] as $chain) {
					$chainTag = XML($chain['function']);
					
					$chainTag->setAttr('select', $selector);
					switch($chain['function']) {
						case 'append':
						case 'prepend':
						case 'replace':
						case 'replaceContent':
							$chainTag->append($chain['args'][0]);
						break;
						case 'eval':
							$chainTag->append('<![CDATA[' . $chain['args'][0] . ']]>');
						break;
						default:
							$count = count($chain['args']);
							for($i = 0; $i < $count; ++$i) {
								$chainTag->setAttr('arg' . ($i + 1), $chain['args'][$i]);
							}
						break;
					}
					
					$taconite->append($chainTag);
				}
			}
			
			return $taconite;
		}
		
		public function __toString() {			
			return (string)$this->render();
		}
	}