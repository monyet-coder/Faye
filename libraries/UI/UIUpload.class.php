<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UIUpload extends div {
        protected $file;
        
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
            $this->file = new input();
			$this->file->setAttr('type', 'file');
            $this->file->appendTo($this);
		}
        
        public function clearChildren() {
            parent::clearChildren();
            
            return $this->append($this->file);
        }
        
        public function setAttr($attrName, $attrValue = NULL) {
            if($attrName === 'name' or $attrName === 'id') {
                return $this->file->setAttr($attrName, $attrValue);
            }
            
            return parent::setAttr($attrName, $attrValue);
        }
	}