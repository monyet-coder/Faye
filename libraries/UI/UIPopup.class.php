<?php
	App::load()->lib('HTML');

	class UIPopup extends UIList {		
		protected function getStyles() {
			return array_merge(parent::getStyles(), array(
				'UI/UI.css',
			));
		}
		
		protected function getScripts() {
			return array_merge(parent::getScripts, array(
				'UI/UIPopup.js',
			));
		}
	}