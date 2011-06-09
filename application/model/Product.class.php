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
        
        public $options = array(
            'CRUD' => array(
                'productID' => array(
                    'type' => 'label',
                ),
                'categoryID' => array(
                    'type' => 'combo',
                    'source' => array(
                        'model' => 'Category',
                        'value' => 'categoryID',
                        'text' => 'categoryName',
                    ),
                ),
                'productPicture' => array(
                    'type'      => 'file',
                    'extension' => array('jpg', 'png', 'gif'),
                    'maxSize'   => 2248,
                ),
                /*
                'productPicture' => array(
                    'type'      => 'img',
                    'resizeTo'  => array('width' => 400, 'height' => 300),
                    'crop'      => array('width' => 100, 'height' => 200),
                ),
                 * 
                 */
            ),
        );
	}