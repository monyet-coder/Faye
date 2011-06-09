<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class User extends Model {
		protected $entityName = __CLASS__;
		protected $primaryKey = 'userID';
	}