<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class cURL {		
		private $URL		= '';
		private $data		= array();		
		private $result		= array();
		private $handler	= NULL;
		private $method		= '';

		public function __construct($URL) {
			$this->URL = $URL;
			
			$this->handler = curl_init($URL);
		}
		
		public function __destruct() {
			curl_close($this->handler);
		}
		
		public function exec($method = Request::GET) {
			if(in_array($this->method, array(Request::GET, Request::PUT, Request::POST, Request::DELETE))) {
				$data = array();
				foreach($this->data as $key => $value) {
					$data[] = $key . '=' . $value;
				}
				
				curl_setopt($this->handler, CURLOPT_POSTFIELDS, implode('&', $data));
			}
			
			curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, $this->method);
			curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, true);
			
			$this->result['content'] = curl_exec($this->handler);
			$this->result['HTTPCode'] = curl_getinfo($this->handler, CURLINFO_HTTP_CODE);
			$this->result['contentType'] = curl_getinfo($this->handler, CURLINFO_CONTENT_TYPE);
			
			return $this->result['content'];			
		}
		
		public function __set($name, $value) {
			$this->data[$name] = $value;
		}
		
		public function __toString() {
			if(empty($this->result['content'])) {
				$this->exec();
			}
			
			return (string)$this->result['content'];
		}
	}