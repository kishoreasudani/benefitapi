<?php
class State extends WecontrolAppModel {
	var $name 			= 'State';
	var $useTable 		= 'states';
	var $actsAs 		= array('Multivalidatable');

	 var $validationSets = array(
		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgName
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Category name is already exists.'
					),
					
			),
			'code' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgCode
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Code is already exists.'
					),
					
			),
		),
		'edit' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgName
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Category name is already exists.'
					),
					
			),
			'code' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	MsgCode
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Code is already exists.'
					),
					
			),
		),
	);

}