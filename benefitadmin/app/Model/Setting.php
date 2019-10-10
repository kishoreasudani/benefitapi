<?php
class Setting extends AppModel {
	var $name 			= 'Setting';
	var $useTable 		= 'settings';
	var $actsAs 		= array('Multivalidatable');

	var $validationSets = array(
		'add' => array(
			'currency' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Currency can\'t be blank.'
				),
				'minLength' => array(
					'rule' => array('minLength', 1),
					'message' => 'Currency must contain 1 character',
					'last'		=> true
				),
				'maxLength' => array(
					'rule' => array('maxLength', 1),
					'message' => 'Currency must contain 1 character',
					'last'		=> true
				),
					
			),

			'contact_no' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Contact can\'t be blank.'
				),
				'minLength' => array(
					'rule' => array('minLength', 10),
					'message' => 'Contact must contain 10 digits',
					'last'		=> true
				),
				'maxLength' => array(
					'rule' => array('maxLength', 10),
					'message' => 'Contact must contain 10 digits',
					'last'		=> true
				),
					
			),
			
			'contact_email' => array(
				'Email'	=> array(
					'rule'	=> 'Email',
					'message'=> 'A valid email is required'
				),			
			),

			'support_email' => array(
				'Email'	=> array(
					'rule'	=> 'Email',
					'message'=> 'A valid email is required'
				),			
			),			 
			
			'footer_message' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Footer message can\'t be blank.'
				),	
				'minLength' => array(
					'rule' => array('minLength', 5),
					'message' => 'Footer message should be more then 5 character',
					'last'		=> true
				),
				'maxLength' => array(
					'rule' => array('maxLength', 50),
					'message' => 'Footer message should be less then 50 character',
					'last'		=> true
				),
			),

			'copy_right' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Country can\'t be blank.'
				),
				'minLength' => array(
					'rule' => array('minLength', 5),
					'message' => 'Copyright signature should be more then 5 character',
					'last'		=> true
				),
				'maxLength' => array(
					'rule' => array('maxLength', 20),
					'message' => 'Copyright signature should be less then 20 character',
					'last'		=> true
				),	
			),	
		
		),
	);
}