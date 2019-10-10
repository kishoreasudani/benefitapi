<?php
class City extends AppModel {
	var $name 			= 'City';
	var $useTable 		= 'cities';
	var $actsAs 		= array('Multivalidatable');

	var $validationSets = array(
		
		'add' => array(
			'city_name' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'City name can\'t be blank.'
				),
				'unique' => array(
					'rule' => 'isUnique',
					'message'=>	'City name already exist.'
				)
			),
			'state_id' => array(
				'notEmpty' => array(
					'rule'	=> 'notEmpty',
					'message'=>	'Select State'
				)										
			)
		)
	);
}
?>