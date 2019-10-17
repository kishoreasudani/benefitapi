<?php
class Vendor extends AppModel {
	var $name 			= 'Vendor';
	var $useTable 		= 'vendors';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		/*add Category*/

		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter vendor name.'
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Name is already exists.'
					),
					
			),

		),
				/*Edit category*/
		'edit' => array(			
			'name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter vendor name.'						
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Name is already exists.'
					),
			)
		)
	
			
	);
}