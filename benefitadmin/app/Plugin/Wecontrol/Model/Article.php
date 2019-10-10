<?php
class Article extends AppModel {
	var $name 			= 'Article';
	var $useTable 		= 'user_articles';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		/*add Category*/

		'add' => array(
			'title' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter title'
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'title is already exists'
					),
					
			),
			'user_id' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select analyst'
					),
			 ),
			'status' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select status'
					),
			 ),
			'approved_status' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select approved status'
					),
			 ),
			'content' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter description'
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