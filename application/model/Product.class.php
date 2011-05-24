<?php
	defined('__SITE_PATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED.');

	class Product extends Model {
		protected $entityName = __CLASS__;
		
		protected $validationRule = array(
			'ProductName' => array(
				'required' => array(
					'message' => '',
				),
				'alphaNumeric',
				'between' => array(3, 25), 
			),
			'CategoryID' => array(
				'required' => NULL,
				'numeric' => NULL,
				'in' => array(
					'message' => 'Category with that ID can\'t be found.',
					1, 2, 3, 4, 5
				),
			),
			'ProductPrice' => array(
				'required' => NULL,
				'numeric' => NULL,
				'greaterThan' => 100000
			),
		);
	}