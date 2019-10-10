<?php
class Blog extends WecontrolAppModel {
	var $name 			= 'Blog';
	var $useTable 		= 'blogs';
	var $actsAs 		= array('Multivalidatable');
	 var $validationSets = array(

		/*Edit Template*/
		'add' => array(
			'title' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter title.'
					),				
			),
			'summary' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter summary.'
					),	
					'between' => array(
						'rule' => array('lengthBetween', 3, 50),
						'message' => 'Summary should be between 3 to 50 characters',
						'last' => true
					),				
            ),
            'content' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter content.'
					),	
					'between' => array(
						'rule' => array('lengthBetween', 3, 1000),
						'message' => 'Content should be between 3 to 1000 characters',
						'last' => true
					),				
			),
			'publish_date' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter publish date.'
					),					
			),
		),
	);

}