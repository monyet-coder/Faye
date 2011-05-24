<?php
	class DataStructureController extends Controller {
		public function index() {
			$this->load->lib('Stack', '/DataStructure');
			$this->load->lib('Queue', '/DataStructure');
			
			$stack = new Stack(array(1, 2, 3, 4, 5));
			$stack->push(6);
			$stack->pop();
			foreach($stack as $key => $item) {
				echo "Stack {$key}: {$item}", HTML('br');
			}
			
			$queue = new Queue(array(1, 2, 3, 4, 5));
			$queue->push(6);
			$queue->pop();
			foreach($queue as $key => $item) {
				echo "Queue {$key}: {$item}", HTML('br');
			}
		}
	}