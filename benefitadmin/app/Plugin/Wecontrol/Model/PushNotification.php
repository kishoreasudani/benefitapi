<?php
class PushNotification extends WecontrolAppModel {
	var $name 			= 'PushNotification';
	var $useTable 		= 'push_notifications';
	var $actsAs 		= array('Multivalidatable');
	 var $validationSets = array(

		/*Edit Template*/
		'add' => array(
            'message' => array(
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
		),
	);

}