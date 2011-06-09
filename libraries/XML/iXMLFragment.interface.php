<?php
    defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

    interface iXMLFragment extends ArrayAccess, Countable {
        public function clearAttr();
        public function setAttr($attrName, $attrValue = NULL);
        public function removeAttr($attrName);
        public function prepend();
        public function append();
        public function appendTo(XMLNode $parent);
        public function prependTo(XMLNode $parent);
        public function render();
        public function __toString();
    }