<?php
class Voucher extends WecontrolAppModel {
	var $name 			= 'Voucher';
	var $useTable 		= 'vouchers';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		/*Edit Template*/
		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter name.'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Name should be between 3 to 20 characters'
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z ]+$/"),
						'message' => 'Name should be alphabetic.'
					)			
			),

			'vendor_id' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select vendor.'
					),			
			    ),

			'code' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter voucher code.'
					),
					'isUnique'	=>	array(
						'rule'		=> 'isUnique',
						'message' 	=> 'Code is already in use. Please provide a different code'				
					)					
			),
			'description' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter description.'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 50),
						'message' => 'Description should be between 3 to 50 characters',
						'last' => true
					),				
			),
			'coins_required' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter required coins.'
					),
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Coins should be numeric.'
					),					
			),
			'discount_type' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select discount type.'
					),				
			),
			'amount' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter voucher amount.'
					),
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Amount should be numeric.'
					),					
			),
			'min_purchase' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter minimum purchase amount.'
					),
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Amount should be numeric.'
					),				
			),
			
			'start_date' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter start date.'
					),				
			),
			'end_date' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter end date.'
					),					
			),
		),
	);

}