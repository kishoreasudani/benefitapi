<?php
class State extends AppModel {
	var $name 			= 'State';
	var $useTable 		= 'states';
	var $actsAs 		= array('Multivalidatable');

	var $validationSets = array(
		
		'add' => array(
			'state_name' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'State name can\'t be blank.'
				),
				'unique' => array(
					'rule' => 'isUnique',
					'message'=>	'State name already exist.'
				)					
			)
		)
	);
}