<?php
class Page extends AppModel {
	var $name 			= 'Page';
	var $useTable 		= 'pages';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		'add' => array(
			'title' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter title'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Title should be between 3 to 20 characters',
						'last' => true
					),
					
			),
			'heading' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter heading'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 50),
						'message' => 'Heading should be between 3 to 50 characters',
						'last' => true
					),
					
			),
			'description' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter description'
					),
			),
		
		),
		'edit' => array(
			'title' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter title'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Title should be between 3 to 20 characters',
						'last' => true
					),
					
			),
			'heading' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter heading'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 50),
						'message' => 'Heading should be between 3 to 50 characters',
						'last' => true
					),					
			),
			'description' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter description'
					),
			),
		
		),
	);
}