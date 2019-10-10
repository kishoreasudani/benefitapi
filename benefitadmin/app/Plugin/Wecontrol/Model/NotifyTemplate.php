<?php
class NotifyTemplate extends WecontrolAppModel {
	var $name 			= 'NotifyTemplate';
	var $useTable 		= 'notify_templates';
	var $actsAs 		= array('Multivalidatable');
	 var $validationSets = array(

		/*Edit Template*/
		'edit' => array(
			'title' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgName
					),				
			),
			'subject' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgCode
					),	
					'between' => array(
						'rule' => array('lengthBetween', 3, 200),
						'message' => 'Subject should be between 3 to 200 characters',
						'last' => true
					),				
			),
			'content' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Please enter email content.'
				),					
			),
		),
	);

}