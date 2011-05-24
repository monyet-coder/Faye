<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	final class Response extends Singleton {
		protected static $instance;
			
		const OK						= 200;
		const CREATED 					= 201;
		const ACCEPTED 					= 202;
		const NO_CONTENT				= 204;
		
		const MOVED_PERMANENTLY		= 301;
		const NOT_MODIFIED				= 304;
		
		const BAD_REQUEST				= 400;
		const UNAUTHORIZED				= 401;
		const FORBIDDEN 				= 403;
		const NOT_FOUND 				= 404;
		const METHOD_NOT_ALLOWED		= 405;
		const REQUEST_TIMEOUT			= 408;
		
		const INTERNAL_SERVER_ERROR 	= 500;
		const NOT_IMPLEMENTED 			= 501;
		const BAD_GATEWAY 				= 502;
		const GATEWAY_TIMEOUT 			= 503;
		
		private $responseContent		= NULL;
		private $protocol 				= 'HTTP/1.1';
		private $HTTPCodes 			= array(
			self::OK 					=> 'OK',
			self::CREATED 				=> 'Created',
			self::ACCEPTED				=> 'Accepted',
			self::NO_CONTENT			=> 'No Content',
			
			self::MOVED_PERMANENTLY		=> 'Moved Permanently',
			self::NOT_MODIFIED			=> 'Not Modified',
			
			self::BAD_REQUEST 			=> 'Bad Request',
			self::UNAUTHORIZED			=> 'Unauthorized',
			self::FORBIDDEN				=> 'Forbidden',
			self::NOT_FOUND			=> 'Not Found',
			self::METHOD_NOT_ALLOWED 	=> 'Method Not Allowed',
			self::REQUEST_TIMEOUT		=> 'Request Timeout',
			
			self::INTERNAL_SERVER_ERROR	=> 'Internal Server Error',
			self::NOT_IMPLEMENTED 		=> 'Not Implemented',
			self::BAD_GATEWAY			=> 'Bad Gateway',
			self::GATEWAY_TIMEOUT		=> 'Gateway Timeout',
		);
		
		public function startBuffering() {
			ob_start();
			
			return $this;
		}
		
		public function getBuffer($append = true) {
			$content = ob_get_contents();
			if($append) {
				$this->responseContent .= $content;
			}
			
			return $content;
		}
		
		public function endBuffering() {
			ob_end_clean();
			
			return $this;
		}
		
		public function setHTTPCode($code) {
			header(sprintf('%s %s %s', $this->protocol, $code, $this->HTTPCodes[$code]), true);
			
			return $this;
		}
		
		public function setContentType($MIMEType) {
			if(!$MIMEType) {
				return $this;
			}
			
			App::load()->lib('MIME');
			if(MIME::getInstance()->__get($MIMEType) !== NULL) {
				$MIMEType = MIME::getInstance()->__get($MIMEType);
			}
			
			header('Content-type: ' . $MIMEType);
			
			return $this;
		}
		
		private function getRedirectURL($args) {
			if(is_string($args[0])) {
				$args[0] = rtrim($args[0], '/');
			}
			
			if(func_num_args() === 2 and is_array($args[1])) {
				$param = array();
				foreach($args[1] as $key => $value) {
					$param[] = $key . '/' . $value;
				}
				
				$args = array_merge((array)$args[0], $param);
			}

			return implode('/', $args);
		}
		
		public function download($fileName) {
			header(sprintf('Content-Disposition: attachment; filename="%s"', $fileName));
		}
		
		public function redirect() {			
			header('Location: ' . $this->getRedirectURL(func_get_args()));
			exit;
		}
		
		public function timeoutRedirect() {
			$args = func_get_args();
			$timeout = array_pop($args);
			
			header('Refresh: ' . $timeout . '; URL=' . $this->getRedirectURL($args));
		}
		
		public function flush() {
			echo $this->__toString();
		}
		
		public function __toString() {
			$this->getBuffer();
			$this->endBuffering();
			
			$this->setContentType(URI::getInstance()->extension);
			
			return $this->responseContent;
		}
	}