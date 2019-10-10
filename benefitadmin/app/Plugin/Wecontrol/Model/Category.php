<?php
class Category extends AppModel {
	var $name 			= 'Category';
	var $useTable 		= 'categories';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		/*add Category*/

		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgName
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'name is already exists.'
					),
					
			),

		),
				/*Edit category*/
		'edit' => array(			
			'name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> MsgName						
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'name is already exists.'
					),
			)
		)
	
			
	);
}