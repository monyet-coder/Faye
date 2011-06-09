<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class Number {
		public static function toReadableSize($size) {
			$mod = 1024;
		 
		    $units = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');
		    for ($i = 0; $size > $mod; $i++) {
		        $size /= $mod;
		    }
		 
		    return round($size, 2) . ' ' . $units[$i];
		}
	}