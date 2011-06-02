<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	      
	App::import('libraries.UI.*');
	
	class CRUDe extends UIForm {
		protected $name;
		protected $model;
        protected $grid;
		protected $headers;
		
		public function __construct(Model $model, $action = NULL) {
            parent::__construct();
			$this->model = $model;
			$this->name = get_class($model);			
            $this->grid = new UIGrid;
            $this->grid->appendTo($this);
			$this->attr('action', $action === NULL ? $action : App::basePath($this->name));

			App::load()->util('String');
			foreach($this->model->getColumn()->getNames() as $name) {
				$this->headers[$name] = String::spaceSeparate($name);
			}
		}
		
		protected function getElement($field, $value = NULL) {
            $option = isset($this->model->options['CRUD'][$field]) ? $this->model->options['CRUD'][$field] : array();
			$type   = $this->model->getColumn()->getType($field);
            $length = $this->model->getColumn()->getLength($field);
            
            $element = NULL;
            if(isset($options['type'])) {
                switch($option['type']) {
                    case 'label':
                        $element = new UIText;
                        $element->append($value);
                    break;
                    case 'text':
                        $element = new UITextField;
                        $element->val($value);
                    break;
                }
            }
            
			switch(strtolower($type)) {
				case 'int':
                    $element = new UINumField;
                    $element->val($value);
				break;
				case 'string':
                    $element = new UITextField;
                    $element->val($value);
				break;
				case 'blob':
					$element = new UITextArea;
                    $element->val($value);
                break;
			}
            
			if($element === NULL) {
                throw new Exception('Can\'t determine element type for field ' . $field . '.');
            }
            
            $element->setAttr(array(
                'id' => $field,
                'name' => $field,
            ));
            
            return $element;
		}
		
		public function create() { return $this->insert(); }
		public function insert() {
			$this->addClass('CRUDe-Insert');
            $this->grid->clearChildren();
			
			foreach($this->model->getColumn()->getNames() as $key => $field) {
				$element = $this->getElement($field);
                
                $this->grid->appendRow(String::spaceSeparate($field), $element);
			}
			
			return $this;
		}
		
		public function read() { return $this->view(); }
		public function view() {
			return $this;
		}
		
		public function edit() { return $this->update(); }
		public function update() {
            $this->addClass('CRUD-Update');
            $this->grid->clearChildren();
            
            foreach($this->model->getColumn()->getNames() as $key => $field) {
                $element = $this->getElement($field, $this->model->__get($field));
                
                $this->grid->appendRow(String::spaceSeparate($field), $element);
            }
            
			return $this;
		}
		
		public function delete() {
			return $this;
		}
	}