<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class UIUpload extends div {
        protected $file;
        protected $meta;
        protected $metaSize;
        protected $metaExtension;
        
		public function __construct($attr = array()) {
			parent::__construct($attr);
			
            $this->file = new input;
			$this->file->setAttr('type', 'file');
            $this->file->appendTo($this);
            
            $this->meta = new UIText;
            $this->meta->addClass('UI-Meta-Data');
            $this->meta->appendTo($this);
            
            $this->metaExtension = new UIText;
            $this->metaExtension->addClass('UI-Meta-Extension');
            $this->metaExtension->appendTo($this->meta);
            
            $this->metaSize = new UIText;
            $this->metaSize->addClass('UI-Meta-Size');
            $this->metaSize->appendTo($this->meta);
		}
        
        public function setMaxSize($size) {
            $this->metaSize->append('Max size : ' . Number::toReadableSize($size));
            
            if($this->metaExtension->hasChildren()) {
                $this->metaSize->prepend(', ');
            }
            
            return $this;
        }
        
        public function setAllowed($type) {
            if(is_array($type)) {
                foreach($type as $t) {
                    $this->setAllowed($t);
                }
                
                return $this;
            }
            
            if(!$this->metaExtension->hasChildren()) {
                $this->metaExtension->append('*.' . $type);
            } else {
                $this->metaExtension->append(', *.' . $type);
            }
            
            return $this;
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
        
        protected function getStyles() {
            return array_merge(parent::getStyles(), array(
                'UI/UI.css',
            ));
        }
        
        public function render() {
            $this->meta->prepend('(')->append(')');
            
            return parent::render();
        }
	}