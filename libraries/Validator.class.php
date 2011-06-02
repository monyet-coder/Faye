<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Validator extends Singleton {
		protected static $instance;
		
		protected $rules = array();
		protected $values = array();
		protected $isValid = true;		
		protected $defaultMessages = array(
			'required' 	=> 'The {FIELD} is required.',
			'numeric'	=> 'The {FIELD} must be a number.',
			'min'		=> 'The minimum value for {FIELD} is {MIN}.',
			'max'		=> 'The maximum value for {FIELd} is {MAX}.',
			'range'		=> 'The {FIELD} must be between {MIN} and {MAX}.',
			'email'		=> 'The {FIELD} must be a valid email address.',
			'in'		=> 'The {FIELD} must be one of these ({COLLECTION}).',
			'extension'	=> 'The {FIELD} extension must be one of these ({EXTENSIONS}).',
			'is'		=> 'The {FIELD} must be equal to {EQUAL}.',
			'equal'		=> 'The {FIELD} must be equal to {EQUAL}.',
			'IP'		=> 'The {FIELD} must contain a valid IP address.',
		);
		
		public $messages = array();
		
		public function defaultMessage($ruleType, $param = array()) {
			if(isset($this->defaultMessages[$ruleType])) {
				$search = array();
				$replace = array();
				foreach($param as $key => $value) {
					$search[] = '{' . $key . '}';
					$replace[] = html('strong')->append(preg_replace('/([A-Z])/', ' \1', $value));
				}
				
				return str_replace($search, $replace, $this->defaultMessages[$ruleType]);
			}
			
			return NULL;
		}
		
		public function required($value) {
			return !empty($value);
		}
		
		public function numeric($value) {
			return is_numeric($value);
		}
		
		public function number($value) {
			return $this->numeric($value);
		}
		
		public function greaterThan($value, $lowerBound) {
			if(is_string($value)) {
				$value = strlen($value);
			}
			
			return $value >= $lowerBound;
		}
		
		public function min($value, $lowerBound) {
			return $this->greaterThan($value, $lowerBound);
		}
		
		public function lowerThan($value, $upperBound) {
			if(is_string($value)) {
				$value = strlen($value);
			}
			
			return $value <= $upperBound;
		}
		
		public function max($value, $lowerBound) {
			return $this->lowerThan($value, $lowerBound);
		}
		
		public function range($value, $bound1, $bound2) {
			$min = min($bound1, $bound2);
			$max = max($bound1, $bound2);
			
			return $this->greaterThan($value, $min) and $this->lowerThan($value, $max);
		}
		
		public function between($value, $start, $end) {
			return $this->range($value, $start, $end);
		}
		
		public function match($value, $pattern) {
			return preg_match($pattern, $value);
		}
		
		public function extension($value, $extensions) {
			return $this->in(pathinfo($value, PATHINFO_EXTENSION), $extensions);
		}
		
		public function in($value, $array) {
			return in_array($value, $array);
		}
		
		public function is($value, $compareValue) {
			return $value === $compareValue;
		}
		
		public function equal($value, $compareValue) {
			return $this->is($value, $compareValue);
		}
		
		public function URL($value) {
			$segments = parse_url($value); 
			
			return ($segments['scheme'] === 'http'|| $segments['scheme'] === 'https') && !empty($segments['host']); 
		}
		
		public function email($value) {
			return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{2,})+$/i', $value);
		}
		
		public function custom($value, $callback) {
			return $callback($value);
		}
		
		public function run($values, $rules = array()) {
			$this->values = $values;
			$this->rules = $rules;
			$this->messages = array();
			$this->isValid = true;
			
			foreach($this->values as $fieldName => $value) {
				foreach($this->rules[$fieldName] as $ruleType => $ruleProperties) {
					$result = true;
					$param = array();
					$message = isset($ruleProperties['message']) ? $ruleProperties['message'] : false;
					
					switch(strtolower($ruleType)) {
						case 'required':
							$result = $this->required($value);
						break;
						case 'number':
						case 'numeric':
							$result = $this->numeric($value);							
						break;
						case 'between':
						case 'range':
							$result = $this->range($value, $ruleProperties[0], $ruleProperties[1]);
							
							$param['MIN'] = min($ruleProperties[0], $ruleProperties[1]);
							$param['MAX'] = max($ruleProperties[0], $ruleProperties[1]);
						break;
						case 'largerthan':
						case 'min':
							$result = $this->largerThan($value, $ruleProperties[0]);
							
							$param['MIN'] = $ruleProperties[0];
						break;
						case 'greaterthan':
						case 'max':
							$result = $this->greaterThan($value, $ruleProperties[0]);
							
							$param['MAX'] = $ruleProperties[0];
						break;
						case 'email':
							$result = $this->email($value);
						break;
						case 'url':
							$result = $this->url($value);
						break;
						case 'extension':
							if(isset($ruleProperties['message'])) {
								$message = $ruleProperties['message'];
								
								unset($ruleProperties['message']);
							}
						
							$collection = $ruleProperties;
							
							if(count($collection) === 1 and is_array($ruleProperties[0])) {
								$collection = $ruleProperties[0];
							}

							$result = $this->extension($value, $collection);
							$param['EXTENSIONS'] = implode(', ', $collection);
						break;
						case 'in':
							if(isset($ruleProperties['message'])) {
								$message = $ruleProperties['message'];
								
								unset($ruleProperties['message']);
							}
						
							$collection = $ruleProperties;

							if(count($collection) === 1 and is_array($ruleProperties[0])) {
								$collection = $ruleProperties[0];
							}

							$result = $this->in($value, $collection);
							$param['COLLECTION'] = implode(', ', $collection);
						break;
						case 'is':
						case 'equal':
							$result = $this->is($value);
							$param['EQUAL'] = $value;
						break;
						case 'custom':
							$result = $this->custom($value, $ruleProperties[0]);
						break;
					}
					
					if($result === false) {
						$this->isValid = false;
						
						$param['FIELD'] = $fieldName;
						$this->messages[] = !empty($message) ? $message : $this->defaultMessage($ruleType, $param);
					}
				}
			}
			
			return $this->isValid;
		}
	}