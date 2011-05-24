<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	abstract class Model extends Entity {
		protected $validationRule = array();
		
		protected $load = NULL;
		protected $URI	= NULL;
		
		public function __construct($configName = Database::DEFAULT_CONFIG) {
			parent::__construct($configName);
			
			$this->load = Loader::getInstance();
			$this->URI 	= URI::getInstance();
		}
		
		public static function exists($modelName) {
			return is_file(__SITE_PATH . '/' . __APPLICATION_PATH . '/' . __MODEL_PATH . '/' . $modelName . '.class.php');
		}
		
		/*
		public function insert() {
			$this->load->lib('Validator');
			
			if(Validator::getInstance()->run($this->data, $this->validationRule)) {				
				return parent::insert();
			}
			
			return $this;
		}
		
		public function update($condition = NULL) {
			$this->load->lib('Validator');
			
			if(Validator::getInstance()->run($this->data, $this->validationRule)) {
				return parent::update($condition);
			}
			
			return $this;
		}
		*/
	}