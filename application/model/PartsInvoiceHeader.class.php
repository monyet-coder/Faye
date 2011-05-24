<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');
	
	class PartsInvoiceHeader extends Model {
		protected $entityName = 'parts_invoice_h';
		protected $primaryKey = 'invoice_no';
		
		public function __construct() {
			parent::__construct('Dpack');
		}
	}